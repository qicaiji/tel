<?php
namespace Home\Model;
//use Think\Model;
use Think\Model\RelationModel;

class JobModel extends RelationModel{

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
			
		'user' => array(
			'mapping_type' => self::BELONGS_TO,
			'class_name' => 'user',
			'mapping_name' => 'user',
			'foreign_key' => 'uid',
			'mapping_fields' => 'realname',
			'as_fields' => 'realname:realname',			
			),
	);
	
	public function showjlist(){
		$job= M(CONTROLLER_NAME);
		if(session('gids')!='1'){
			$map['j.cid'] = session('cid');
		}
		//部门名称列表
		return $job
				-> table('__JOB__ as j')
				-> field('jid,jname,j.sort,j.status,c.cname')
				-> join('left join __COMPANY__ c on j.cid = c.cid')
				-> where($map) 
				-> order('j.cid,j.sort desc,jid') 
				-> select();
	}
	
}