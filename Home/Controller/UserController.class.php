<?php
namespace Home\Controller;
//use Think\Controller;
use Common\Common\Controller\AuthController;

class UserController extends AuthController {

	public function index(){
			$user = D(CONTROLLER_NAME);
			
			//管理员可以查询所有，非超级管理员只能查询自己企业的数据
			//部门管理员级别以上的可以管理企业内所有用户
			//普通用户只能查看和修改自己的资料
			$listRows = 10;
			$ulist = $user -> userList($listRows);
			$this -> assign('ulist',$ulist);
			
			//输出UID字符串
			$this -> assign('uidstr',$this->getIDstr($ulist));
		
			//输出页码链接
			$this -> assign('page',$user->showPage($map,$listRows));
			
			$this -> display();
	}
	
	private function getIDstr($list){
		$ids = array();
		foreach($list as $one){
			if($one['uid'] != session('uid')){
				$ids[] = $one['uid'];
			}
		}
		$idstr = implode(',',$ids);
		return $idstr;
	}
	
	public function showlist(){
			$user = D(CONTROLLER_NAME);
			
			//如果没有进行查询，则输出页码链接，否则不输出页码
			if(strlen(I('realname'))<1 && strlen(I('did'))<1 && strlen(I('jid'))<1){
				$listRows = 10;
				$this -> assign('page',$user->showPage($search_map,$listRows));
			}
			
			//管理员可以查询所有，非超级管理员只能查询自己企业的数据
			$dlist = $user -> getList('department');
			//管理员可以查询所有，非超级管理员只能查询自己企业的数据
			$jlist = $user -> getList('job');
			
			//用于搜索
			$this -> assign('searchdlist',$dlist);
			$this -> assign('searchjlist',$jlist);

			//输出查询用户结果
			$this -> assign('ulist',$user->searchList($listRows));
			
			$this -> display();
	}
	
	/*
	
	//message ajax
	public function savelist(){
		//var_dump(I('messages'));
		//echo I('messages');
		
		$messages = explode(';',I('messages'));
		if(session('?messages')){
			$old = session('messages');
			$messages = array_unique(array_merge($old,$messages));
			session('messages',$messages);
			//echo implode(';',$messages);
			
		}else{
			session('messages',$messages);
		}
		
		echo count($messages);
	}
	
	public function getlist(){
		//var_dump(session('messages'));
		
		//获取企业短信条数
		if(session('?cid')){
			$company = M('company') -> find(session('cid'));
			$this -> assign('company',$company);
		}
		
		$array = array();
		foreach(session('messages') as $m){
			$array[] = explode(',',$m);
		}
		$this -> assign('list',$array);
		$this -> display();
		
	}
	
	public function dellist(){
		session('messages',null);
		echo 1;
	}
	
	public function showmessagelog(){
		//获取企业短信记录
		if(session('?cid')){
			$messagelog = M('messagelog') -> where(array('cid'=>session('cid'))) -> order('id desc') -> select();
		}else{
			$messagelog = M('messagelog') -> order('id desc') -> select();
		}
		
		$this -> assign('mlist',$messagelog);
		$this -> display();
		//var_dump($messagelog);
	}
	
	private function messagelog($content,$tellist,$failCount,$errlist){
		$data['cid'] = session('cid');
		$data['uid'] = session('uid');
		$data['realname'] = session('realname');
		$data['sendtime'] = time();
		$data['ip'] = get_client_ip();
		$data['content'] = $content;
		$data['tellist'] = $tellist;
		$data['sendallcount'] = count(explode(',',$data['tellist']));
		$data['sendtrue'] = $data['sendallcount'] - $failCount; //发送成功的数量
		$data['sendfalse'] = $failCount;	//发送失败的数量
		$data['errlist'] = $errlist;
		//var_dump($data);
		if(session('?cid')){
			//扣除企业短信
			$one = M('company') -> find(session('cid'));
			$data2['cid'] = session('cid');
			$data2['message'] = $one['message'] - $data['sendtrue'];
			M('company') -> save($data2);
		}
		
		if(M('messagelog')->add($data)){
			return true;
		}else{
			return false;
		}
	}
	
	//发送短信
	public function sendmessage(){
		//检查企业短信是否充足
		if(session('?cid')){
			$one = M('company') -> find(session('cid'));
			$sendnum = count(explode(',',I('tellist')));
			if($one['message'] < $sendnum){
				$result = '{"respCode":"短信余额不足！"}';
				return 1;
			}
		}
		
		$config = array(
			'url' => "https://api.miaodiyun.com/20150822/industrySMS/sendSMS",//BASE_URL
			'sid' => "ba9638748edf4b2e9c2342f03291db68", // 主账户ACCOUNT_SID
			'pwd' => "3d12ff096b664bcc96c19469c0d75587",//AUTH_TOKEN
			'type' => "application/x-www-form-urlencoded",//CONTENT_TYPE
			'json' => "application/json",//ACCEPT
		);

		$body = array(
			'accountSid' => $config['sid'],
			'timestamp' => date('YmdHis'),
			'sig' => md5($config['sid'] . $config['pwd'] . date('YmdHis')),
			'respDataType' => "JSON",
			'smsContent' => I('content'),
			'to' => I('tellist'),
		);
		
		//判断发送给列表，还是企业内所有人
		if(I('sendto') === 'all' and session('?cid')){
			$map['cid'] = session('cid');
			$ulist = D('user') -> where($map) -> relation(true) -> select();
			$tlist = array();
			foreach($ulist as $one){
				$tlist[] = $one['fulltel'];
			}
			$body['to'] = implode(',',$tlist);
		}
		
		// 提交请求
		$result = $this -> sendpost($config,$body);
		$re = json_decode($result,true);
		//var_dump($re);
		
		//错误记录
		$err_arr = array();
		if(!empty($re['failList'])){
			foreach($re['failList'] as $one_err){
				$err_arr[] = '错误电话:'.$one_err['phone'].',错误代码:'.$one_err['respCode'];
			}
			$err_str = implode(';',$err_arr);
			//var_dump($err_str);
		}
		if(intval($re['respCode']) == 0){
			$this -> messagelog(I('content'),I('tellist'),$re['failCount'],$err_str);
			$sendnum = count(explode(',',I('tellist')));
			echo '{"respCode":'.intval($re['respCode']).
				 ',"total":'.$sendnum. 
				 ',"success":'.($sendnum - $re['failCount']).
				 ',"err":'.$re['failCount'].
				 ',"errstr":"'.$err_str.'"}';
				 
			//清空发送列表
			session('messages',null);
		}else{
			echo $result;
		}
	}
	
	//构造请求数据
	private function sendpost($config,$body){
		$url = $config['url'];
		$headers = array('Content-type:'.$config['type'],'Accept:'.$config['json']);

		// 要求post请求的消息体为&拼接的字符串，所以做下面转换
		$temp = array();
		foreach($body as $key=>$val){
			$temp[] = $key.'='.$val;
		}
		$fields_string = implode('&',$temp);
		
		// 提交请求
		$con = curl_init();
		curl_setopt($con, CURLOPT_URL, $url);
		curl_setopt($con, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($con, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($con, CURLOPT_HEADER, 0);
		curl_setopt($con, CURLOPT_POST, 1);
		curl_setopt($con, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($con, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($con, CURLOPT_POSTFIELDS, $fields_string);
		$result = curl_exec($con);
		curl_close($con);

		return "" . $result;
	}
	
	*/
	
	public function add(){
		if(!IS_POST){
			if(session('gids')=='1'){		//超级管理员则可以选择企业名称
				$this -> assign('clist',M('company')->select());
			}
			
			//用户组名称列表
			if(session('gids') == 1){
				$this -> assign('glist',D('group')->select());
			}else{
				$this -> assign('glist',D('group')->childGroups());
			}
			
			//添加页面
    		$this -> display();
		}else{	
			//执行添加
			$user = D(CONTROLLER_NAME);
			$data = $user->addData();
			if($data){
				if($user -> create($data)){
					$uid = $user -> relation(array('tel')) -> add($data);
					//添加middle表记录
					foreach(I('gid') as $gid){
						$middle['uid'] = $uid;
						$middle['group_id'] = $gid;
						M('middle') -> add($middle);
					}
					$this -> success('添加成功！初始密码为身份证号，请尽快更改！',U('index'),3);
				}else{
					$this -> error($user -> getError());
				}
			}else{
				$this -> error('两次输入的身份证不同！');
			}
			
		}
	}
	
	public function department(){
		if(!IS_POST){
			//部门名称列表，添加后通过编辑所属部门来设置
			if(session('gids')!='1'){	//非超级管理员只能选择自己所在企业的部门
				$map['cid'] = session('cid');
			}
			$this -> assign('dlist',M('department')->where($map)->order('sort')->select());
			
			//输出用户信息
			$map2['uid'] = I('uid');
			$user = M('user')->where($map2)->find();
			$this -> assign('user',$user);
			
			//输出用户已设置了的部门列表
			$udlist = explode(',',$user['dids']);
			$this -> assign('udlist',$udlist);
			
			$this -> display();
			
		}else{
			$user = M(CONTROLLER_NAME);
			
			//ID两边加点号，提供查询时的准确性，
			//否则查询%1%可能得到包含1的所有ID，如11,12,21...
			//$data['dids'] = implode(',',I('did'));
			foreach(I('did') as $did){
				$didstr[] .= '.'.$did.'.';
			}
			$data['dids'] = implode(',',$didstr);
			$data['uid'] = I('uid');

			if($user -> save($data)){
				$this -> success('设置成功！',U('index'));
			}else{
				$this -> error($user -> getError());
			}
		}
	}
	
	public function job(){
		if(!IS_POST){
			//职位名称列表，添加后通过编辑所属部门来设置
			if(session('gids')!='1'){	//非超级管理员只能选择自己所在企业的部门
				$map['cid'] = session('cid');
			}
			$this -> assign('jlist',M('job')->where($map)->select());
			
			//输出用户信息
			$map2['uid'] = I('uid');
			$user = M('user')->where($map2)->find();
			$this -> assign('user',$user);
			
			//输出用户已设置了的职位列表
			$ujlist = explode(',',$user['jids']);
			$this -> assign('ujlist',$ujlist);
			
			$this -> display();
			
		}else{
			$user = M(CONTROLLER_NAME);
			
			//ID两边加点号，提供查询时的准确性，
			//否则查询%1%可能得到包含1的所有ID，如11,12,21...
			//$data['jids'] = implode(',',I('jid'));
			foreach(I('jid') as $jid){
				$jidstr[] = '.'.$jid.'.';
			}
			$data['jids'] = implode(',',$jidstr);
			$data['uid'] = I('uid');

			if($user -> save($data)){
				$this -> success('设置成功！',U('index'));
			}else{
				$this -> error($user -> getError());
			}
		}
	}
	
    public function edit(){
		$uid = intval(I('uid'));
    	$user = D(CONTROLLER_NAME);
		$one = $user ->relation('tel') -> find($uid);
		if(!$one){
			$this -> error('非法参数！');
		}
		
		//权限检查
		R(CONTROLLER_NAME.'/'.ACTION_NAME,array($one),'Logic');
		
    	if(!IS_POST){
			//显示编辑页面
			$this -> assign('one',$one);
			
			if(session('gids')=='1'){		//超级管理员则可以选择企业名称
				$this -> assign('clist',M('company')->select());
			}
			
			//用户组名称列表
			if(session('gids')!='1'){	//非超级管理员只能选择自己所管辖的用户组
				$this -> assign('glist',D('group')->childGroups());
			}else{
				$this -> assign('glist',M('group')->select());
			}
		
			//编辑页面
			$this -> display();

		}else{
			//执行编辑
			$data = $user->editData();
			if($user -> create($data)){
				$re1 = $user -> relation(array('tel')) -> save($data);
				if($re1){
					//修改middle表记录：先删除以前的，再新增现在的
					$middle['uid'] = $data['uid'];
					$re2 = M('middle') -> where($middle) -> delete();
					
					foreach(I('gid') as $gid){
						$middle['group_id'] = $gid;
						$re3 = M('middle') -> add($middle);
					}
					
					if($re2 && $re3){
						if(session('uid') == $uid  && strlen(I('pwd')) > 0){
							//修改密码后须重新登录
							$this -> success('修改密码成功，请重新登录！',U('login/logout'));
							exit;
						}
						$this -> success('修改成功！',U('index'));
					}
				}
			}else{
				$this -> error($user -> getError());
			}
		}
    }
	
	public function del(){
		$uid = intval(I('uid'));
		
		//禁止删除自己
		if(session('uid') == $uid){
			$this -> error('开玩笑？严禁自杀！');
		}
		
		$user = D(CONTROLLER_NAME);
		$one = $user ->relation('tel') -> find($uid);
		
		//权限检查
		R(CONTROLLER_NAME.'/edit',array($one),'Logic');

		$map['uid'] = $uid;
		if($user -> where($map) -> relation(array('tel')) -> delete()){
			$middle['uid'] = $uid;
			$re = M('middle') -> where($middle) -> delete();
			$this -> success('删除成功！',U('index'));
		}else{
			$this -> error('删除失败！');
		}
	}
	
	//删除当前页面显示的所有ID
	public function delpage(){
		$user = D('user');
		$map['uid'] = array('in',I('uidstr'));	//待安全验证！
		if(session('gids') != 1){
			//只能删除本单位的记录
			$map['cid'] = session('cid');
		}
		$del_users = $user -> relation(true) -> where($map) -> select();
		foreach($del_users as $del){
			//权限检查
			R(CONTROLLER_NAME.'/edit',array($del),'Logic');
			if($del['uid'] == session('uid')){
				$this -> error('开玩笑？严禁自杀！');
			}
		}
		
		$re1 = $user -> relation(true) -> where($map) -> delete();
		if($re1){
			$map['uid'] = array('in',I('uidstr'));
			$re2 = M('middle') -> where($map) -> delete();
			if($re2){
				$this -> success('删除成功！');
			}else{
				$this -> success('删除用户成功，但删除中间表失败！');
			}
		}else{
			$this -> error('删除失败！');
		}
	}
	
	//删除所有信息
	public function delall(){
		$user = D('user');
		if(session('cid') > 0){
			$map['uid'] = array('neq',session('uid'));
			$map['cid'] = session('cid');
		}else{
			$this -> error('删除失败：你不属于任何企业！',U('index'));
		}
		
		$re1 = $user -> where($map) -> relation(true) -> delete();
		if($re1){
			$middle['uid'] = $uid;
			$re2 = M('middle') -> where($middle) -> delete();
			if($re2){
				$this -> success('删除成功',U('index'));
			}else{
				$this -> success('删除用户成功，但删除中间表失败！');
			}
		}else{
			$this -> error('删除失败：'.$user -> getError(),U('index'));
		}
	}
	
	public function r_manage(){
		return array(
			'index' => '用户管理首页',
			'showlist' => '通讯录',
			'savelist' => '保存发送列表',
			'getlist' => '准备发送短信',
			'dellist' => '删除发送列表',
			'showmessagelog' => '显示日志列表',
			'messagelog' => '短信发送日志',
			'sendmessage' => '发送短信',
			'sendpost' => '发送post',
			'add' => '添加用户',
			'department' => '设置用户所属部门',
			'job' => '设置用户所属职位',
			'edit' => '修改用户',
			'del' => '删除用户',
			'delpage' => '删除本页',
			'delall' => '全部删除'
		);
	}
}