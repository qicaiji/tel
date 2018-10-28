<?php
namespace Home\Controller;
//use Think\Controller;
use Common\Common\Controller\AuthController;

class CompanyController extends AuthController {
    
	public function index(){
		if(session('?cid')){
			$clist = M(CONTROLLER_NAME) -> where('cid='.session('cid')) -> order('sort desc') -> select();
		}else{
			$clist = M(CONTROLLER_NAME) -> order('sort desc') -> select();
		}
		
		$this -> assign('clist',$clist);
		$this -> display();
	}
	
	public function add(){
		if(!IS_POST){
			//添加页面
    		$this -> display();
		}else{
			//执行添加
			$company = D(CONTROLLER_NAME);
			if($company -> create()){
				$company -> createtime = time();
				$company -> add();
				$this -> success('添加成功！',U('index'));
			}else{
				$this -> error($company -> getError());
			}
		}
	}
	
    public function edit(){
		//权限检查
		R(CONTROLLER_NAME.'/'.ACTION_NAME,array($cid),'Logic');
		
		$cid = intval(I('cid'));
    	$company = D(CONTROLLER_NAME);
    	
		if(!IS_POST){
			//显示编辑页面
			$one = $company -> find($cid);
			if(!$one){
				$this -> error('没有找到：'.$cid);
			}
			$this -> assign('one',$one);
			$this -> display();
		}else{
			//执行编辑
			if($company -> create()){
				$company -> save();
				$this -> success('修改成功！',U('index'));
			}else{
				$this -> error($company -> getError());
			}
		}
    }
	
	public function message(){
		$cid = intval(I('cid'));
    	$company = D(CONTROLLER_NAME);
			
    	if(!IS_POST){
			//显示编辑页面
			$one = $company -> find($cid);
			if(!$one){
				$this -> error('没有找到：'.$cid);
			}
			$this -> assign('one',$one);
			$this -> display();
		}else{
			$data['cid'] = $cid;
			$data['uid'] = session('uid');
			$data['realname'] = session('realname');
			$data['sendtime'] = time();
			$data['ip'] = get_client_ip();
			$data['content'] = '++增加短信';
			$data['sendallcount'] = intval(I('message'));
			//var_dump($data);
			
			//记录日志
			$messagelog = M('messagelog');
			$messagelog -> startTrans();	//开启事务
			$re1 = $messagelog->add($data);
			
			//执行添加
			$one = M(CONTROLLER_NAME) -> find($cid);
			$data2['cid'] = $cid;
			$data2['message'] = intval($one['message']) + intval(I('message'));
			$re2 = M(CONTROLLER_NAME) -> save($data2);

			if($re1 and $re2){
				$messagelog -> commit();	//正式提交
				$this -> success('添加成功！',U('index'));
			}else{
				$messagelog -> rollback();	//事务回滚
				$this -> error('添加失败！');
			}
			
		}
    }
	
	public function del(){
		$cid = intval(I('cid'));
		if(M(CONTROLLER_NAME) -> delete($cid)){
			$this -> success('删除成功！',U('index'));
		}else{
			$this -> error('删除失败！');
		}
	}
	
	public function r_manage(){
		return array(
			'index' => '企业列表管理首页',
			'add' => '添加企业',
			'edit' => '修改企业',
			'message' => '添加短信',
			'del' => '删除企业',
		);
	}

	}