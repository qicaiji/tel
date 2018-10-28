<?php
return array(
	//'配置项'=>'配置值'
	'DB_TYPE' => 'mysql',
	'DB_HOST' => 'localhost',
	'DB_USER' => 'root',
	'DB_PWD' => 'baijdfe110',
	'DB_NAME' => 'telbook',
	'DB_PORT' => '3306',
	'DB_PREFIX' => 'telbook_',
	
	//跟踪调试
	//'SHOW_PAGE_TRACE' =>true, 
	
	//自定义权限认证表名称
	'AUTH_CONFIG' => array(
        'AUTH_GROUP'        => 'telbook_group',        	// 用户组数据表名
        'AUTH_GROUP_ACCESS' => 'telbook_middle', 		// 用户-用户组关系表
        'AUTH_RULE'         => 'telbook_rule',         	// 权限规则表
        'AUTH_USER'         => 'telbook_user'           // 用户信息表
	),
	
	'TMPL_PARSE_STRING' =>array(
		'__PUBLIC__' => __ROOT__.'/Common/Common', // 更改默认的/Public
	),
	
	//seesion前缀
	'SESSION_PREFIX' => 'tel',
);