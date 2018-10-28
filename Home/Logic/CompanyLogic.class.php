<?php
namespace Home\Logic;
use Think\Controller;

class CompanyLogic extends Controller{
	public function edit($cid){
		//超级管理员
		if(session('gids') == 1){
			return true;
		}
		
		if(session('cid') == $cid){
			return true;
		}else{
			$this -> error('非法操作！');
		}
	}
}