<?php
namespace Home\Logic;
use Think\Controller;

class GroupLogic extends Controller{
	public function edit($id,$user_gids){
		//超级管理员
		if($user_gids == 1){
			return true;
		}
		
		$edit_group = M(CONTROLLER_NAME) -> find($id);
		
		//禁止更改公共角色
		if($edit_group['cid'] == 0){
			$this -> error('禁止更改公共角色！');
		}
		
		
		if(session('cid') == $edit_group['cid']){
			//多角色的，只要符合一个即可
			foreach(explode(',',$user_gids) as $gid){
				if($id == $gid){
					return true;
				}
			}
			
			//都不符合的，如果是相同的cid，上下级关系也行
			$rlist = R(CONTROLLER_NAME.'/getRuleList','','Model');
			$rule_ids = array();
			foreach($rlist as $row){
				$rule_ids[] = $row['id'];
			}
			
			foreach(explode(',',$edit_group['rules']) as $rule){
				if(!in_array($rule,$rule_ids)){
					$this -> error('权限不够！');
				}
			}
		}else{
			$this -> error('没有权限！');
		}
		
		return true;
	}
}