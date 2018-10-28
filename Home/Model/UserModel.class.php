<?php
namespace Home\Model;
//use Think\Model;
use Think\Model\RelationModel;

class UserModel extends RelationModel{
	protected $_validate = array(
		array('card', '', '身份证已存在！',2,'unique',self::MODEL_BOTH),

	);
	protected $_link = array(
		//关联企业名称表
		'company' => array(
			'mapping_type' => self::BELONGS_TO,
			'foreign_key' => 'cid',
			'mapping_fields' => 'cname',
			'as_fields' => 'cname:cname',
			),
		
		//关联用户组名称表
		'group' => array(
			'mapping_type' => self::BELONGS_TO,
			//'parent_key' => 'gids',
			'foreign_key' => 'gids',
			'mapping_fields' => 'title',
			'as_fields' => 'title:gtitle',
			
			),
			
		//关联权限中间表
		'middle' => array(
			'mapping_type' => self::HAS_ONE,
			'foreign_key' => 'uid',
			'mapping_fields' => 'group_id',
			'as_fields' => 'group_id:gid',
			),
			
		//关联电话表
		'tel' => array(
			'mapping_type' => self::HAS_ONE,
			'foreign_key' => 'uid',
			'mapping_fields' => 'vtel,fulltel,otel,hometel,familytel,mail,uptime',
			'as_fields' => 'vtel,fulltel,otel,hometel,familytel,mail,uptime',
			),	
	);
	
	public function userList($listRows){
		$user = D(CONTROLLER_NAME);
		
		//管理员可以查询所有，非超级管理员只能查询自己企业的数据
		if(session('gids') != 1){
			$map['u.cid'] = session('cid');
		}

		$ulist = $user 
				 -> table('__USER__ u')
				 -> join('left join __GROUP__ g on u.gids = g.id')
				 -> join('left join __COMPANY__ c on u.cid = c.cid')
				 -> field('uid,realname,u.status,u.cid,dids,jids,gids,g.title gtitle,cname')
				 -> page(I('p'),$listRows) 
				 -> where($map) 
				 -> select();

		//把部门ids替换成文字
		$ulist = $this->replaceIdsToNames($ulist,'department','dids','did','dname');

		//把职位ids替换成文字
		$ulist = $this->replaceIdsToNames($ulist,'job','jids','jid','jname');

		return $ulist;
	}
	
	//把用户信息中的部门ID串替换成文字
	private function replaceIdsToNames($ulist,$tablename,$ids_name,$id_name,$n_name){
		
		$namelist= $this -> replaceID2Str($this->getList($tablename),$id_name,$n_name);
		
		for($i=0;$i<count($ulist);$i++){
			$user_ids= explode(',',str_ireplace('.','',$ulist[$i][$ids_name]));
			$id_names= array();
			foreach($user_ids as $user_id){
				$id_names[] = $namelist[$user_id];	//把用户所属ID转换成name
			}		
			$ulist[$i][$ids_name] = implode(',',$id_names);		  //把原来的ID字符串替换name字符串
		}

		return $ulist;
	}
	
	public function getList($tablename){
		
		//管理员可以查询所有，非超级管理员只能查询自己企业的数据
		if(session('gids')!='1'){
			$map['cid'] = session('cid');
		}
		
		return M($tablename)->where($map)->select();
	}
	
	private function replaceID2Str($list,$id_name,$n_name){
		$array = array();
		foreach($list as $one){
			//数组[部门ID]=部门名称
			$array[$one[$id_name]] = $one[$n_name];
		}
		return $array;
	}
	
	public function searchList($listRows){
		$user = D(CONTROLLER_NAME);
		
		if(session('gids')!=='1'){
			//查询所属企业
			$search_map['cid'] = session('cid');
		}
		//按部门查询
		if(strlen(I('did'))){
			$search_map['dids'] = array('like','%.'.I('did').'.%');
			$listRows = 500;
		}
		//按职位查询
		if(strlen(I('jid'))){
			$search_map['jids'] = array('like','%.'.I('jid').'.%');
			$listRows = 500;
		}
		$content = I('content');
		if(strlen($content)){
			if(is_numeric($content)){
				$search_map_tel['vtel|fulltel|otel|hometel|familytel|mail'] = array('like','%'.$content.'%');
				$tel_list = M('tel') -> where($search_map_tel) -> field('uid') -> select();		//查询号码对应的uid
				if(count($tel_list)){
					foreach($tel_list as $tel){
						$tels[] = $tel['uid'];
					}
					$tel_uid_str = implode(',',$tels);		//把uid数组组成字符串
					$search_map['uid'] = array('in',$tel_uid_str);
				}else{
					$search_map['uid'] = 0;
				}
			}else{
				$search_map['realname'] = array('like','%'.$content.'%');
			}
			$listRows = 500;
		}
		
		//输出用户列表
		$ulist = $user -> page(I('p'),$listRows) -> relation('tel') 
					   -> where($search_map) -> order('uptime desc') -> select();

		//把部门ids替换成文字
		$ulist = $this->replaceIdsToNames($ulist,'department','dids','did','dname');
		
		//把职位ids替换成文字
		$ulist = $this->replaceIdsToNames($ulist,'job','jids','jid','jname');
		
		return $ulist;
	}
	
	public function showPage($map,$listRows){
		//分页
		$count = M('user') -> where($map) -> count();
		$page = new \Think\Page($count,$listRows);
		$page -> setConfig('prev','上一页');
		$page -> setConfig('next','下一页');
		$page -> setConfig('first','首页');
		$page -> setConfig('last','末页');
		$page -> lastSuffix = false;  // 最后一页是否显示总页数
		return $page -> show();
	}
	
	public function checkEditRight($uid){
		if(session('gids')=='1'){
			return true;
		}

		if(session('gids')!='5'){
			$edit_uid = M('user') -> find($uid);
			//企业管理员只能修改自己企业的员工，且不能修改超级管理员
			if(session('cid')==$edit_uid['cid'] and $edit_uid['gids']!='1'){
				return true;
			}else{
				return false;
			}
		}
		
		//如果是普通成员，则只能修改自己的信息
		if(session('gids')=='5'){
			if(session('uid')==$uid){
				return true;
			}else{
				return false;
			}
		}
		
	}
	
	public function addData(){
		if(I('card')!==I('card2')){
			//$this -> error('两次输入的身份证不同！');
			return false;
		}
		$data['realname'] = I('realname');
		$data['card'] = I('card');
		$data['pwd'] = md5($data['card']);
		$data['status'] = I('status');
		$data['uptime'] = time();
		$data['cid'] = I('cid');
		$data['gids'] = implode(',',I('gid'));
		$data['creater'] = session('realname');
		
		//关联权限中间表
		/* $data['middle'] = array(
				'group_id' => $data['gids'],
		); */
			
		//关联电话表表
		$data['tel'] = array(
				'vtel' => I('vtel'),
				'fulltel' => I('fulltel'),
				'otel' => I('otel'),
				'hometel' => I('hometel'),
				'familytel' => I('familytel'),
				'mail' => I('mail'),
				'uptime' => time(),
		);
		
		return $data;
	}
	
	public function editData(){
		if(I('pwd')!==I('pwd2')){
			return false;
		}
		$data['uid'] = intval(I('uid'));
		$data['realname'] = I('realname');
		if(strlen(I('pwd'))>0){
			$data['pwd'] = md5(I('pwd'));
		}
		$data['status'] = I('status');
		$data['uptime'] = time();
		$data['card'] = I('card');
		$data['cid'] = I('cid');
		$data['gids'] = implode(',',I('gid'));
		
		//关联权限中间表
		/* $data['middle'] = array(
				'group_id' => $data['gids'],
		); */
			
		//关联电话表表
		$data['tel'] = array(
				'vtel' => I('vtel'),
				'fulltel' => I('fulltel'),
				'otel' => I('otel'),
				'hometel' => I('hometel'),
				'familytel' => I('familytel'),
				'mail' => I('mail'),
				'uptime' => time(),
		);
		
		return $data;
	}
	
}