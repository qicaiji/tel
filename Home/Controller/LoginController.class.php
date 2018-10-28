<?php
namespace Home\Controller;
use Think\Controller;
use Think\Verify;

class LoginController extends Controller {
    public function index(){
        if(!IS_POST){
			if(cookie('tel_save_login')){
				//使用cookie登陆
				$save_login = cookie('tel_save_login');
				$map['realname'] = $save_login[0];
				$map['password'] = $save_login[1];
				$data = M('user') -> where($map) -> find();
				$this -> _login($data);
			}
			
			$this -> display();
		}else{
			$verify = new Verify();
			if(!$verify->check(I('verifyImg'))){
				$this -> error('验证码错误！',U(ACTION_NAME));
			}
			
			if(cookie('wrongtimes')){
				$this -> error('已连续错了3次，请5分钟后再试！');
			}
			
			if(session('wrongtimes') >= 3){
				cookie('wrongtimes',3,300);
				session('wrongtimes',null);
				$this -> error('已连续错了3次，请5分钟后再试！','',10);
			}
			
			//验证登陆信息
			$user = D('user');
			$map['realname'] = I('realname');
			$map['pwd'] = md5(I('pwd'));
			$data = $user -> relation(true) -> where($map) -> find();
			
			if(empty($data)){
				$this -> error('账号或密码不对！');
			}else{
				//登陆成功，创建session
				if($data['status']==0){
					$this -> error('对不起，此账号已被禁用，请联系管理员！');
				}
				
				foreach($data as $key=>$val){
					session($key,$val);
				}
				
				//保存登陆信息到cookies，下次自动登陆
				if(I('save_login') == 'yes'){
					$save_login = array();
					$save_login[] = session('realname');
					$save_login[] = session('password');
					cookie('save_login',
						$save_login,
						array('expire'=>3600*24*365,'prefix'=>'tel_')
					);
				}
			
				//显示欢迎信息
				$this -> success('欢迎回来！'.session('realname'),U('index/index'),1);
			}
			
		}
    }
	
	public function _before_index(){
		if($_SERVER['HTTP_HOST'] != 'tel.wscc.cn'){
			//redirect('http://tel.wscc.cn/tel/');
		}
	}
	
	private function _login($data){
		if(empty($data)){
			$this -> error('账号或密码不对！');
		}else{
			//登陆成功，创建session
			foreach($data as $key=>$val){
				session($key,$val);
			}
			//保存登陆信息到cookies，下次自动登陆
			if(I('save_login') == 'yes'){
				$save_login = array();
				$save_login[] = session('realname');
				$save_login[] = session('password');
				cookie('save_login',
					$save_login,
					array('expire'=>3600*24*365,'prefix'=>'tel_')
				);
			}
			
			//显示欢迎信息
			$this -> success('欢迎回来！'.session('realname'),U('index/index'),1);
			exit;
		}
	}
	
	public function verifyImg(){
		//设置验证码参数
		$config = array(
			'fontSize' => 15,	//验证码字体大小
			'length' => 6,	//验证码位数
			'useNoise' => false,	//关闭验证码杂点
			'useCurve' => false,	//取消曲线混淆
			'codeSet' => '0123456789',
			'fontttf' => '2.ttf',
			'imageH' => 30,
			'imageW' => 150,
			//'seKey' => 'wscccn',
		);
		//实例化验证码类
		$verify = new Verify($config);
		//生成一个验证码图形
		$verify->entry();
	}
	
	public function logout(){
		cookie('tel_save_login',null);
		session('[destroy]');
		$this->success('退出成功！',U('index'),1);
	}
	
	//捐助本站
	public function pay(){
		$this -> display();
	}
	
	public function r_manage(){
		return array(
			
		);
	}
}