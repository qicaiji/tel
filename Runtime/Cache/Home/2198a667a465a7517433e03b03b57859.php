<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="/thinkphp/tel/Common/Common/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="/thinkphp/tel/Common/Common/css/telbook.css" />
<!-- 页面独立的css文件 -->
<title>职位列表</title>
</head>
<body>
    <div class="container-fluid" id="header">
	<div class="row">
	    <div class="col-xs-12 col-sm-4">
	    	<a href="<?php echo U('index/index');?>">
	        	<img src="/thinkphp/tel/Common/Common/image/logo.png" id="logo" title="企业通讯录" style="width:280px;" />
	        </a>
	    </div>
	    
	    <div class="col-xs-12 col-sm-8 text-nowrap text-right welcome">
            <?php if(session('uid') > 0): ?>欢迎回来：<?php echo session('realname');?> 
            	<a href="<?php echo U('User/edit',array('uid'=>session('uid')));?>">[修改]</a> |
		        <a href="<?php echo U('login/logout');?>">退出</a><?php endif; ?> 
	    </div>
	</div>
</div>
 
    <ul class="nav nav-tabs text-center" id="menu">
<!--    <li class="text-center"><a href="<?php echo U('index/index');?>">首页</a></li>-->

	<li class="dropdown text-center">
		<a href="#" data-toggle="dropdown">
			站务<span class="caret"></span>
		</a>
		<ul class="dropdown-menu">
			<?php if(session('gids') == 1): ?><li><a href="<?php echo U('Importrules/index');?>">权限导入</a></li><?php endif; ?>
			<li><a href="<?php echo U('group/index');?>">组管理</a></li>
			<li><a href="<?php echo U('company/index');?>">企业管理</a></li>
			<li><a href="<?php echo U('index/delruntime');?>">清理缓存</a></li>
		</ul>
	</li>

	
	<?php if(session('gids') < 5): ?><li class="dropdown text-center">
			<a href="#" data-toggle="dropdown">
				管理<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">
				<li><a href="<?php echo U('department/index');?>">部门管理</a></li>
				<li><a href="<?php echo U('job/index');?>">职位管理</a></li>
				<li><a href="<?php echo U('user/index');?>">用户管理</a></li>
			</ul>
		</li><?php endif; ?>
	<li class="text-center"><a href="<?php echo U('user/showlist');?>">通讯录</a></li>
	
	<li class="text-center"><a href="<?php echo U('login/pay');?>">捐助</a></li>

    <!--<li class="text-center">
    	<a href="javascript:alert('作者：四川隆昌二中 陈晨 det@qq.com');" class="shouji_hidden">关于</a>
    </li>-->
</ul>
    <div id="content">
	
	<table class="table table-bordered table-hover table-striped">
    	<thead>
            <tr>
            	<th class="width-1">ID</th>
                <th class="width-2">职位名称</th>
				<th class="width-1">排序</th>
				<?php if(session('gids') == 1): ?><th class="width-1">状态</th>
					<th class="width-2">所属企业</th><?php endif; ?>
				<th class="width-2">管理</th>
				</tr>
        </thead>
        <tbody>
            <?php if(is_array($jlist)): $i = 0; $__LIST__ = $jlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one): $mod = ($i % 2 );++$i;?><tr>
                	<td><?php echo ($one["jid"]); ?></td>
                    <td><?php echo ($one["jname"]); ?></td>
					<td><?php echo ($one["sort"]); ?></td>
					<?php if(session('gids') == 1): ?><td><?php echo ($one["status"]); ?></td>
						<td><?php echo ($one["cname"]); ?></td><?php endif; ?>
                    <td>
                        <a href="<?php echo U('edit',array('jid'=>$one['jid']));?>">编辑</a> | 
                        <a href="<?php echo U('del',array('jid'=>$one['jid']));?>" onClick="javascript:return del()">删除</a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    <div>
    	<a href="<?php echo U('add');?>" id="add_button" class="btn btn-info btn-block">添加</a>
    </div>

</div>	  
    <div id="footer">
	Power By WSCC ：det@qq.com

</div>
    

<script type="text/javascript" src="/thinkphp/tel/Common/Common/js/jquery-2.2.3.js"></script></script>
<script type="text/javascript" src="/thinkphp/tel/Common/Common/js/bootstrap.js"></script></script>

<script type="text/javascript" src="/thinkphp/tel/Common/Common/js/telbook.js"></script>

<!-- 单页使用 this_page_script -->
</body>
</html>