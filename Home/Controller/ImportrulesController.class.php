<?php
namespace Home\Controller;
//use Think\Controller;
use Common\Common\Controller\AuthController;
class ImportrulesController extends AuthController {
	
	public function index(){
		//本函数功能：导入所有控制器权限节点

		//获取所有控制器的方法名称
		$array = $this -> getNames();

		if(!I('do')){
			$this -> assign('list',$array);
			$this -> display();
		}else{
			//添加所有控制器方法的节点权限
			$rule = M('rule');
			$i = 0;
			$temp = array();	//用于删除不存在的权限节点
			foreach($array as $one){
				$temp[] = $one['name'];	
				if(!$rule -> where('name="'.$one['name'].'"') -> select()){
					//如果不存在则增加
					if($rule -> create($one)){
						$rule -> add();
						$i++;
					}
				}else{
					//如果存在则更新title
					$rule -> where('name="'.$one['name'].'"') -> save($one);
				}
			}
			
			//删除已过期的节点（也可以设置status为0）
			$map['name'] = array('not in',implode(',',$temp));
			$del_count = $rule -> where($map) -> count();
			if($del_count){
				$rule -> where($map) -> setField('status',0);
			}
			
			$this -> success('成功导入'.$i.'个节点，禁用'.$del_count.'个过期节点',U('index'));
		}
    }
	
	public function delNames(){
		$re = M('rule') -> where('status=0') -> delete();
		if($re){
			$this -> success('清理完成！');
		}
	}
	
	private function getNames(){
		//获取后台控制器文件夹
		$dir = scandir(APP_PATH.MODULE_NAME.'/Controller/');
		$array = array();
		foreach($dir as $file){
			if($file == '.' || $file == '..'){
				continue;
			}else{
				//只处理控制器类
				if(substr($file,-20)=='Controller.class.php'){
					//获取类的所有方法
					foreach(R(substr($file,0,-20).'/r_manage') as $key=>$title){
						//把方法路径和名称映射到数组中
						$array[] = array(
							'name' => MODULE_NAME.'/'.substr($file,0,-20).'/'.$key,
							'title' => $title,
						);
					} 
				}
			}
		}
		return $array;
	}
	
	public function r_manage(){
		return array(
			'index' => '导入权限节点',
		//	'test' => 'test',
		);
	}
	
}