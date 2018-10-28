<?php
namespace Home\Model;
use Think\Model;

class GroupModel extends Model{
	protected $_validate = array(
		array('title','require','用户组名称不能为空'),
		array('title', '', '该名称已存在！',2,'unique',self::MODEL_BOTH),
	);
	
	public function getGlist(){
		if(session('gids') != '1'){
			//只能查看公共角色，和企业内部的角色
			$map['cid'] = array('in',array(0,session('cid')));
			$glist = M('group') -> field('*,status as gstatus') -> where($map) -> select();
		}else{
			//超级管理员
			$glist = M('group') 
					 -> table('__GROUP__ g')
					 -> field('id,title,g.status as gstatus,rules,g.cid as gcid,c.cid as ccid,c.cname,c.status as cstatus')
					 -> join('left join __COMPANY__ c on g.cid=c.cid')
					 -> select();
		}
		return $glist;
	}
	
	//返回下属角色
	public function childGroups(){
		$group = M('group');
		
		//获取角色列表的所有权限节点
		$user_rlist = $this -> getRuleList();
		$user_rids = array();
		foreach($user_rlist as $row){
			$user_rids[] = $row['id'];
		}
		$user_rules = array_unique($user_rids);
		
		$map['id'] = array('neq','1');
		$glist = $group -> where($map) -> select();
		//var_dump($glist);
		
		$childglist = array();
		foreach($glist as $g){
			if(intval($g['cid']) > 0 && $g['cid'] != session('cid')){
				continue;
			}
			
			$testRules = array_merge(explode(',',$g['rules']),$user_rules);
			//如果该组的每个权限都存在于当前用户的权限中，则是下属组
			if(count($user_rules)==count(array_unique($testRules))){
				$childglist[] = $g;
			}
			unset($testRules);
		}
		return $childglist;
	}
	
	//返回用户当前拥有的权限列表
	public function getRuleList($user_gids=0){
		if($user_gids == 0){
			$user_gids = session('gids');
		}
		$rule = M('rule');
		$gids = explode(',',$user_gids);
		if($user_gids == 1){	
			//超级管理员可以设置任意权限
			$rlist =  $rule -> order('name') -> select();
		}else{
			//非超级管理员只能设置自己相关的权限
			$map['id'] = array('in',$user_gids);
			$user_groups = M('group') -> where($map) -> select();
			$user_rules = array();
			foreach($user_groups as $g){
				$user_rules[] = $g['rules'];
			}
			$map['id'] = array('in',implode(',',$user_rules));
			$rlist =  $rule -> where($map) -> order('name') -> select();
		}
		return $rlist;
	}
	
	//可删除
	public function checkEditRight($gid){
		//检查用户是否有权限编辑的指定的组
		//要修改的组的权限必须全部存在于登陆用户的权限中
		
		//超级管理员直接通过检查
		if(session('gids')=='1'){	
			return true;
		}
		
		$user = M(CONTROLLER_NAME) -> find(session('gids'));
		//登陆用户的权限
		$edit_rules = explode(',',$user['rules']);
		
		//要编辑的组的权限是否都存在于登陆用户的权限
		$one = M(CONTROLLER_NAME) -> find($gid);
		
		foreach(explode(',',$one['rules']) as $rule){
			if(!in_array($rule,$edit_rules)){
				return false;
			}
		}
		return true;
	}
}