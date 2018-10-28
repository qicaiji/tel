<?php
namespace Home\Event;
use Think\Controller;

class DataEvent extends Controller{
	public function company($array=null){
		if(empty($array)){
			$this -> error('参数不能为空！');
		}else{
			$data['title'] = $array['title'];
			$data['uptime'] = time();
			$data['endtime'] = time() + 3600*24*$array['days'];
			var_dump($data);
			exit;
		}
	}
}