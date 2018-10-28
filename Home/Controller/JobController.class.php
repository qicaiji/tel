<?php
namespace Home\Controller;
//use Think\Controller;
use Common\Common\Controller\AuthController;

class JobController extends AuthController {
    
	public function index(){
		//职位名称列表
		$jlist = D(CONTROLLER_NAME) -> showjlist();
		$this -> assign('jlist',$jlist);
		
		$this -> display();
	}
	
	public function add(){
		if(!IS_POST){
			if(session('gids')=='1'){		//超级管理员则可以选择企业名称
				$this -> assign('clist',M('company')->select());
			}
			//添加页面
    		$this -> display();
		}else{
			$jnames = explode(' ',trim(I('jname')));
			$data = array();
			$i = 0;
			foreach($jnames as $jname){
				if(trim($jname) != ''){
					$data[$i]['jname'] = $jname;
					$data[$i]['cid'] = I('cid');
					$data[$i]['sort'] = I('sort');
					$data[$i]['status'] = I('status');
					$i++;
				}
			}
			
			$re= M(CONTROLLER_NAME) -> addAll($data);
			if($re){
				$this -> success('添加成功！',U('index'));
			}else{
				$this -> error('添加失败');
			}
		}
	}
	
    public function edit(){
		$jid = intval(I('jid'));
		$jobs = D(CONTROLLER_NAME);
		$one = $jobs -> find($jid);
		
		//权限检查
		R(CONTROLLER_NAME.'/'.ACTION_NAME,array($one['cid']),'Logic');
		
    	if(!IS_POST){
			//显示编辑页面
    		if(!$one){
				$this -> error('没有找到：'.$jid);
			}
			
			$this -> assign('one',$one);
			$this -> display();
		}else{
			//执行编辑
			if($jobs -> create()){
				$jobs -> save();
				$this -> success('修改成功！',U('index'));
			}else{
				$this -> error($jobs -> getError());
			}
		}
    }
	
	public function del(){
		$jid = intval(I('jid'));
		$jobs = D(CONTROLLER_NAME);
		$one = $jobs -> find($jid);
		
		if(!$one){
			$this -> error('没有找到：'.$jid);
		}
		
		//权限检查
		R(CONTROLLER_NAME.'/edit',array($one['cid']),'Logic');
		
		if($jobs -> delete($jid)){
			$this -> success('删除成功！',U('index'));
		}else{
			$this -> error('删除失败！');
		}

	}
	
	public function r_manage(){
		return array(
			'index' => '职务列表首页',
			'add' => '添加职务',
			'edit' => '修改职务',
			'del' => '删除职务',
		);
	}
}