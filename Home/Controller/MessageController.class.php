<?php
namespace Home\Controller;
//use Think\Controller;
use Common\Common\Controller\AuthController;

class MessageController extends AuthController {
	//保存群发列表
	public function savelist(){
		//var_dump(I('messages'));
		//echo I('messages');
		
		$messages = explode(';',I('messages'));
		if(session('?messages')){
			$old = session('messages');
			$messages = array_unique(array_merge($old,$messages));
			session('messages',$messages);
			//echo implode(';',$messages);
			
		}else{
			session('messages',$messages);
		}
		
		echo count($messages);
	}
	
	//显示群发列表
	public function getlist(){
		//var_dump(session('messages'));
		
		//获取企业短信条数
		if(session('?cid')){
			$company = M('company') -> find(session('cid'));
			$this -> assign('company',$company);
		}
		
		$array = array();
		foreach(session('messages') as $m){
			$array[] = explode(',',$m);
		}
		$this -> assign('list',$array);
		$this -> display();
		
	}
	
	//删除群发列表
	public function dellist(){
		session('messages',null);
		echo 1;
	}
	
	//查看短信群发日志
	public function showmessagelog(){
		//获取企业短信记录
		if(session('?cid')){
			$messagelog = M('messagelog') -> where(array('cid'=>session('cid'))) -> order('id desc') -> select();
		}else{
			$messagelog = M('messagelog') -> order('id desc') -> select();
		}
		
		$this -> assign('mlist',$messagelog);
		$this -> display();
		//var_dump($messagelog);
	}
	
	//记录短信日志
	private function messagelog($content,$tellist,$failCount,$errlist){
		$data['cid'] = session('cid');
		$data['uid'] = session('uid');
		$data['realname'] = session('realname');
		$data['sendtime'] = time();
		$data['ip'] = get_client_ip();
		$data['content'] = $content;
		$data['tellist'] = $tellist;
		$data['sendallcount'] = count(explode(',',$data['tellist']));
		$data['sendtrue'] = $data['sendallcount'] - $failCount; //发送成功的数量
		$data['sendfalse'] = $failCount;	//发送失败的数量
		$data['errlist'] = $errlist;
		//var_dump($data);
		if(session('?cid')){
			//扣除企业短信
			$one = M('company') -> find(session('cid'));
			$data2['cid'] = session('cid');
			$data2['message'] = $one['message'] - $data['sendtrue'];
			M('company') -> save($data2);
		}
		
		if(M('messagelog')->add($data)){
			return true;
		}else{
			return false;
		}
	}
	
	//发送短信
	public function sendmessage(){
		//检查企业短信是否充足
		if(session('?cid')){
			$one = M('company') -> find(session('cid'));
			$sendnum = count(explode(',',I('tellist')));
			if($one['message'] < $sendnum){
				$re['respCode'] = '短信余额不足！';
				$this -> ajaxReturn($re);
			}
		}
		
		$config = array(
			'url' => "https://api.miaodiyun.com/20150822/industrySMS/sendSMS",//BASE_URL
			'sid' => "", // 主账户ACCOUNT_SID
			'pwd' => "",//AUTH_TOKEN
			'type' => "application/x-www-form-urlencoded",//CONTENT_TYPE
			'json' => "application/json",//ACCEPT
		);

		$body = array(
			'accountSid' => $config['sid'],
			'timestamp' => date('YmdHis'),
			'sig' => md5($config['sid'] . $config['pwd'] . date('YmdHis')),
			'respDataType' => "JSON",
			'smsContent' => I('content'),
			'to' => I('tellist'),
		);
		
		//判断发送给列表，还是企业内所有人
		if(I('sendto') === 'all' and session('?cid')){
			$map['cid'] = session('cid');
			$ulist = D('user') -> where($map) -> relation(true) -> select();
			$tlist = array();
			foreach($ulist as $one){
				$tlist[] = $one['fulltel'];
			}
			$body['to'] = implode(',',$tlist);
		}
		
		// 提交请求
		$result = $this -> sendpost($config,$body);
		$re = json_decode($result,true);
		//var_dump($re);
		
		//错误记录
		$err_arr = array();
		if(!empty($re['failList'])){
			foreach($re['failList'] as $one_err){
				$err_arr[] = '错误电话:'.$one_err['phone'].',错误代码:'.$one_err['respCode'];
			}
			$err_str = implode(';',$err_arr);
			//var_dump($err_str);
		}
		if(intval($re['respCode']) == 0){
			$this -> messagelog(I('content'),I('tellist'),$re['failCount'],$err_str);
			$sendnum = count(explode(',',I('tellist')));
			echo '{"respCode":'.intval($re['respCode']).
				 ',"total":'.$sendnum. 
				 ',"success":'.($sendnum - $re['failCount']).
				 ',"err":'.$re['failCount'].
				 ',"errstr":"'.$err_str.'"}';
				 
			//清空发送列表
			session('messages',null);
		}else{
			echo $result;
		}
	}
	
	//构造请求数据
	private function sendpost($config,$body){
		$url = $config['url'];
		$headers = array('Content-type:'.$config['type'],'Accept:'.$config['json']);

		// 要求post请求的消息体为&拼接的字符串，所以做下面转换
		$temp = array();
		foreach($body as $key=>$val){
			$temp[] = $key.'='.$val;
		}
		$fields_string = implode('&',$temp);
		
		// 提交请求
		$con = curl_init();
		curl_setopt($con, CURLOPT_URL, $url);
		curl_setopt($con, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($con, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($con, CURLOPT_HEADER, 0);
		curl_setopt($con, CURLOPT_POST, 1);
		curl_setopt($con, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($con, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($con, CURLOPT_POSTFIELDS, $fields_string);
		$result = curl_exec($con);
		curl_close($con);

		return "" . $result;
	}
	
	public function r_manage(){
		return array(
			'savelist' => '保存发送列表',
			'getlist' => '准备发送短信',
			'dellist' => '删除发送列表',
			'showmessagelog' => '显示日志列表',
			'sendmessage' => '发送短信',
		);
	}
}