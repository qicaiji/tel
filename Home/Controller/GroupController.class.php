<?php
namespace Home\Controller;
//use Think\Controller;
use Common\Common\Controller\AuthController;
class GroupController extends AuthController {
    
	public function index(){
		$glist = D(CONTROLLER_NAME) -> getGlist();
		
		//把rule id 替换成文字
		for($i=0;$i<count($glist);$i++){
			if($glist[$i]['rules'] != ''){
				$map['id'] = array('in',$glist[$i]['rules']);
				$rules = M('rule') -> field('title') -> where($map) -> order('name') -> select();
				$temp = array();
				foreach($rules as $rule){
					$temp[] = $rule['title'];
				}
				$glist[$i]['rules_title'] = implode('，',$temp);
			}
		}
		
		$this -> assign('glist',$glist);
		$this -> display();
	}
	
    public function add(){
		if(!IS_POST){
			//输出权限列表
			$this -> assign('rlist',D(CONTROLLER_NAME)->getRuleList());
			
			if(session('gids') == '1'){
				//输出企业列表
				$this -> assign('clist',M('company')->select());
			}
			
			//添加页面
    		$this -> display();
		}else{
			//执行添加
			$group = D(CONTROLLER_NAME);
			if($group -> create()){
				$group -> rules = implode(',',I('rule'));
				$group -> add();
				$this -> success('添加成功！',U('index'));
			}else{
				$this -> error($group -> getError());
			}
		}
	}
	
    public function edit(){
		$id = intval(I('id'));	//=gid
		
    	//权限检查
		R(CONTROLLER_NAME.'/'.ACTION_NAME,array($id,session('gids')),'Logic');
		
		$group = D(CONTROLLER_NAME);
		
    	if(!IS_POST){
			//显示编辑页面
    		if(!empty($id)){
    			//查找编辑对象
				$one = $group->find($id);
				if(!$one){
					$this -> error('没有找到：'.$id);
				}
    			$this -> assign('one',$one);
				
				//输出用户当前拥有的权限列表
				$this -> assign('rlist',$group->getRuleList());

				//输出企业列表
				$this -> assign('clist',M('company')->select());
				
				//用于自动勾选本组用户已设置了的权限
				$grlist = explode(',',$one['rules']);
				$this -> assign('grlist',$grlist);
				
    			$this -> display();
    		}else{
				$this -> error('ID不能为空！');
			}
		}else{
			//执行编辑
			if($group -> create()){
				$group -> rules = implode(',',I('rule'));
				if($group -> save()){
					$this -> success('修改成功！',U('index'));
				}else{
					$this -> error('修改失败……');
				}
			}else{
				$this -> error($group -> getError());
			}
		}
    }
	
	public function del(){
		$id = intval(I('id'));
		
		//权限检查
		R(CONTROLLER_NAME.'/edit',array($id,session('gids')),'Logic');
		
		if(M(CONTROLLER_NAME) -> delete($id)){
			$this -> success('删除成功！',U('index'));
		}else{
			$this -> error('删除失败！');
		}

	}
	
	public function r_manage(){
		return array(
			'index' => '用户组首页',
			'add' => '添加用户组',
			'edit' => '修改用户组',
			'del' => '删除用户组',
		);
	}
	
}