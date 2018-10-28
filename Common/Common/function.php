<?php

function check_company(){
	if(session('gids') == 1) return true;
	if(session('cid') == I('cid')) return true;
	return false;
}

function check_department(){
	//超级管理员
	if(session('gids') == 1) return true;
	
	//企业管理员
	$dp = M('department') -> find(I('did'));
	if(session('gids') == 2){
		if($dp['cid'] == session('cid')){
			return true;
		}else{
			return false;
		}
	}
	
	//部门管理员
	$dids = explode(',',session('dids'));
	if(session('cid') == $dp['cid'] and in_array(I('did'),$dids)) return true;
	return false;
}