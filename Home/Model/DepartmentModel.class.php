<?php
namespace Home\Model;
//use Think\Model;
use Think\Model\RelationModel;

class DepartmentModel extends RelationModel{
	protected $_validate = array(
		array('sort', '0,99', '排序必须是0-99之间的数字', 1, 'between'),
	);
	protected $_link = array(
	//关联用户与用户组的关联表，增删改用户的时候用到
		'company' => array(
			'mapping_type' => self::BELONGS_TO,
			'class_name' => 'company',
			'mapping_name' => 'company',
			'foreign_key' => 'cid',
			'mapping_fields' => 'cname',
			'as_fields' => 'cname:cname',			
		),
	);
	


	public function showdlist(){
		$department = M(CONTROLLER_NAME);
		if(session('gids')!='1'){
			$map['d.cid'] = session('cid');
		}
		//部门名称列表
		return $department 
				-> table('__DEPARTMENT__ as d')
				-> field('d.did,dname,d.sort,d.status,c.cname')
				-> join('left join __COMPANY__ c on d.cid = c.cid')
				-> where($map) 
				-> order('d.cid,d.sort desc,did') 
				-> select();
	}
}