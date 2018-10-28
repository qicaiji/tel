<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="/thinkphp/tel/Common/Common/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="/thinkphp/tel/Common/Common/css/telbook.css" />
<!-- 页面独立的css文件 -->
<title>通讯录首页</title>
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
	

    <div style="text-align:center;font-size:2em;line-height:2em;">
    	<div>
    		欢迎回来！<?php echo session('realname');?>
    	</div>
    	<div id="screen_width"></div>
    	<div id="browser_core"></div>
    	<div id="notice" style="color:red;font-size:0.8em;"></div>
    </div>


</div>	  
    <div id="footer">
	Power By WSCC ：det@qq.com

</div>
    

<script type="text/javascript" src="/thinkphp/tel/Common/Common/js/jquery-2.2.3.js"></script></script>
<script type="text/javascript" src="/thinkphp/tel/Common/Common/js/bootstrap.js"></script></script>

<script type="text/javascript" src="/thinkphp/tel/Common/Common/js/telbook.js"></script>


	<script type="text/javascript" src="/thinkphp/tel/Common/Common/js/browserdetect.js"></script>
	<script>
		$("#screen_width").html("屏幕分辨率：" + document.body.clientWidth);
		
		$("#browser_core").html("浏览器内核：" + BrowserDetect.browser);
		
		if(BrowserDetect.browser !== "Chrome"){
			var notice = "本站开发者主要支持谷歌内核的浏览器（Chrome），<br>如果你在操作中遇到兼容问题，<br>请下载安装【谷歌浏览器】体验本站所有功能！";
			$("#notice").html(notice);
		}
	</script>
	

</body>
</html>