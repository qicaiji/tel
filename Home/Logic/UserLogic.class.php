<?php
namespace Home\Logic;
use Think\Controller;

class UserLogic extends Controller{
	public function edit($one){
		//可以修改自己的账号
		if(session('uid') == $one['uid']){
			return true;
		}
		
		//超级管理员
		if(session('gids') == 1){
			return true;
		}
		
		if(session('cid') != $one['cid']){
			$this -> error('非法操作！');
		}
		
		//获取当前用户的权限列表
		$user_rlist = D('group') -> getRuleList();
		$user_rids = array();
		foreach($user_rlist as $row){
				$user_rids[] = $row['id'];
		}
		
		//获取要编辑的用户的权限列表
		$edit_rlist = D('group') -> getRuleList($one['gids']);
		$edit_rids = array();
		foreach($edit_rlist as $row){
				$edit_rids[] = $row['id'];
		}
		
		//当前用户的权限必须包含要编辑用户的所有权限，并且权限总数大于对方
		$all_rule = array_merge($user_rids,$edit_rids);
		$all_rule = array_unique($all_rule);
		if(count($user_rids) > count($edit_rids)){
			if(count($all_rule) == count($user_rids)){
				return true;
			}else{
				$this -> error('你的权限不足以管理：All');
			}
		}else{
			$this -> error('你的权限不足以管理：User');
		}
	}
}