<?php
namespace Home\Model;
use Think\Model;

class CompanyModel extends Model{
	protected $_validate = array(
		array('title','require','企业名称不能为空'),
		array('title', '', '该名称已存在！',2,'unique',self::MODEL_BOTH),
		array('sort', '0,99', '排序必须是0-99之间的数字', 1, 'between'),
	);

	public function checkEditRight($cid){
		if(session('gids') == 1) return true;
		if($cid==session('cid')){
			return true;
		}else{
			return false;
		}
	}

}