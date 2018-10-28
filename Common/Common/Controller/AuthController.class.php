<?php
namespace Common\Common\Controller;
use Think\Controller;
use Think\Auth;

class AuthController extends Controller{
		protected function _initialize(){
			//获取登陆信息
			$uid = session('uid');
			
			if(empty($uid)){
				$this->error('请先登陆！',U('Login/index'),1);
			}
			
			//如果是管理员，则不用验证权限了
			if(session('gids') == '1'){
				return true;
			}
			
			//验证权限
			$auth = new Auth();
			if(!$auth->check(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME,$uid)){
				$this->error('没有权限','',1);
			}
		}
}
