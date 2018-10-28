<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="/thinkphp/tel/Common/Common/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="/thinkphp/tel/Common/Common/css/telbook.css" />

	<link rel="stylesheet" type="text/css" href="/thinkphp/tel/Common/Common/css/controller/<?php echo (CONTROLLER_NAME); ?>.css" />

<title>修改用户组</title>
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
	
	<form action="<?php echo U(ACTION_NAME);?>" method="post">
		<!-- 用户组ID： -->
		<input type="hidden" name="id" value="<?php echo ($one['id']); ?>" />

		<div class="container-fluid">
			<div class="row">
				<label class="col-xs-3 col-sm-4 text-right">组名称：</label>
				<div class="col-xs-8 col-sm-4">
					<input type="text" name="title" value="<?php echo ($one['title']); ?>" />
				</div>
	   		</div>
	   		
	   		<div class="row">
				<label class="col-xs-3 col-sm-4 text-right">状态：</label>
				<div class="col-xs-8 col-sm-4">
					<?php if($one['status'] == '1'): $selected = 'selected'; endif; ?> 
					<select name="status">
						<option value="0">禁用</option>
						<option value="1" <?php echo ($selected); ?>>正常</option>
					</select>
				</div>
	   		</div>
	   		
	   		<div class="row">
				<label class="col-xs-3 col-sm-4 text-right">所属企业：</label>
				<div class="col-xs-8 col-sm-4">
					<select name="cid">
						<?php if(session('gids') == 1): ?><option value="0">公共</option><?php endif; ?>
						<?php if(is_array($clist)): $i = 0; $__LIST__ = $clist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i; if($vo['cid'] == $one['cid']): $selected = 'selected'; ?>
							<?php else: ?>
								<?php $selected = ''; endif; ?> 
							<option value="<?php echo ($vo["cid"]); ?>" <?php echo ($selected); ?>><?php echo ($vo["cname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>
	   		</div>
	   		
	   		<div class="row">
				<label class="col-xs-3 col-sm-4 text-right">组权限：</label>
	   		</div>
	   		
	   		<?php if(is_array($rlist)): $i = 0; $__LIST__ = $rlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$rlist): $mod = ($i % 2 );++$i;?><div class="row">
					<label class="col-xs-3 col-sm-4"></label>
	                <?php $checked = ''; ?>
	                <?php if(in_array($rlist[id],$grlist)): $checked = 'checked'; endif; ?>
	    			
	                <label class="col-xs-8 col-sm-7">
	                    <input type="checkbox" name="rule[]" value="<?php echo ($rlist["id"]); ?>" <?php echo ($checked); ?> />
	                    <?php echo ($rlist["title"]); ?>：<?php echo ($rlist["name"]); ?>
	                </label>
		   		</div><?php endforeach; endif; else: echo "" ;endif; ?>
	    
	    	<div class="row">
		    	<div class="col-xs-2 col-sm-3"></div>
		    	<div class="col-xs-6 col-sm-4">
		    		<input type="submit" class="btn btn-info btn-block" value="提交" />
		    	</div>
   			</div>
   		</div>
	</form>

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