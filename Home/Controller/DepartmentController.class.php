<?php
namespace Home\Controller;
//use Think\Controller;
use Common\Common\Controller\AuthController;

class DepartmentController extends AuthController {
    
	public function index(){
		//部门名称列表
		$dlist = D(CONTROLLER_NAME) -> showdlist();
		$this -> assign('dlist',$dlist);

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
			//执行添加			
			$dnames = explode(' ',trim(I('dname')));
			$data = array();
			$i = 0;
			foreach($dnames as $dname){
				if(trim($dname) != ''){
					$data[$i]['dname'] = $dname;
					$data[$i]['status'] = intval(I('status'));
					$data[$i]['sort'] =  intval(I('sort'));
					$data[$i]['cid'] =  intval(I('cid'));
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
		$did =  intval(I('did'));
		$department = D(CONTROLLER_NAME);
		$one = $department -> find($did);
		
		//权限检查
		R(CONTROLLER_NAME.'/'.ACTION_NAME,array($one['cid']),'Logic');
		
    	if(!IS_POST){
			//显示编辑页面
			if(!$one){
				$this -> error('没有找到：'.$did);
			}
			
			$this -> assign('one',$one);
			$this -> display();
		}else{
			//执行编辑
			if($department -> create()){
				$department -> save();
				$this -> success('修改成功！',U('index'));
			}else{
				$this -> error($department -> getError());
			}
		}
    }
	
	public function del(){
		$did = intval(I('did'));
		$department = M(CONTROLLER_NAME);
		$one = $department -> find($did);
		
		if(!$one){
			$this -> error('没有找到：'.$did);
		}
			
		//权限检查
		R(CONTROLLER_NAME.'/edit',array($one['cid']),'Logic');
		
		if($department -> delete($did)){
			$this -> success('删除成功！',U('index'));
		}else{
			$this -> error('删除失败！');
		}

	}
	
	public function r_manage(){
		return array(
			'index' => '部门列表首页',
			'add' => '添加部门',
			'edit' => '修改部门',
			'del' => '删除部门',
		);
	}
}