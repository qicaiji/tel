<?php
namespace Home\Controller;
//use Think\Controller;
use Common\Common\Controller\AuthController;


class IndexController extends AuthController {
    public function index(){		
        $this->display();
    }
	
	public function _before_index(){
		if($_SERVER['HTTP_HOST'] != 'tel.wscc.cn'){
			//redirect('http://tel.wscc.cn/tel/');
		}
	}
	
	public function delruntime($path = RUNTIME_PATH){
		//var_dump(RUNTIME_PATH);
		//exit;

		// 打开目录
		$dh = opendir($path);
		// 循环读取目录
		while(($file = readdir($dh)) !== false){
			// 过滤掉当前目录'.'和上一级目录'..'
			if($file == '.' || $file == '..') continue;
			// 如果该文件是一个目录，则进入递归
			if(is_dir($path.'/'.$file)){
				$this -> delruntime($path.'/'.$file);
			} else {
				// 如果不是一个目录，则将其删除
				unlink($path.'/'.$file);
			}
		}
		// 退出循环后(此时已经删除所有了文件)，关闭目录并删除
		closedir($dh);
		if(rmdir($path)){
			$this -> success('清理缓存完毕！',U('index'));
			exit;
		}
	}
	
	public function r_manage(){
		return array(
			'index' => '登陆后台首页',
			'delruntime' => '清除缓存',
		);
	}
	
}