<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">

	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" type="text/css" href="/thinkphp/tel/Common/Common/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="/thinkphp/tel/Common/Common/css/telbook.css" />
		<link rel="stylesheet" type="text/css" href="/thinkphp/tel/Common/Common/css/controller/<?php echo (CONTROLLER_NAME); ?>.css" />
		<title>登陆企业通讯录</title>
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

		<div id="content">
			<form id="login_form" action="<?php echo U(ACTION_NAME);?>" method="post">
				<div class="container-fluid">
					<div class="row">
						<div class="col-xs-4 col-sm-4 text-right">姓名</div>
						<div class="col-xs-7 col-sm-4 input_text">
							<input type="text" name="realname" required class="text-center bottom10" />
						</div>
					</div>

					<div class="row">
						<div class="col-xs-4 col-sm-4 text-right">密码</div>
						<div class="col-xs-7 col-sm-4 input_text">
							<input type="password" name="pwd" required class="text-center bottom10" />
						</div>
					</div>

					<div class="row">
						<div class="col-xs-4 col-sm-4 text-right">验证码</div>
						<div class="col-xs-7 col-sm-4 input_text">
							<input type="number" name="verifyImg" required class="text-center bottom10" />
						</div>
					</div>
					
					<div class="row">
						<div class="col-xs-4 col-sm-4 text-right"></div>
						<div class="col-xs-7 col-sm-2 input_text bottom10">
							<img src="<?php echo U('verifyImg');?>" id="verifyImg" title="点击刷新" /><br>点击图片刷新
						</div>
					</div>
					
					<div class="row">
						<div class="col-xs-4 col-sm-4 text-right">保存登陆</div>
						<div class="col-xs-7 col-sm-2 input_text bottom10">
							<label>
								<input type="checkbox" name="save_login" value="yes" checked style="width:15px;height:15px;" /> 下次自动登陆
							</label>
						</div>
					</div>

					<div class="row">
						<div class="col-xs-4 col-sm-4"></div>
						<div class="col-xs-7 col-sm-4">
							<input type="submit" class="btn btn-primary bottom10" value="登陆" />
						</div>
					</div>
				</div>

				<div class="text-center">
					<a href="/thinkphp/tel/Common/Common/image/sjdl.png" target="_blank">
						<img src="/thinkphp/tel/Common/Common/image/sjdl.png" style="max-width:300px;margin:20px;" />
					</a>
				</div>
			</form>

		</div>
		<div id="footer">
	Power By WSCC ：det@qq.com

</div>
		<script type="text/javascript" src="/thinkphp/tel/Common/Common/js/jquery-2.2.3.js"></script>
		</script>
		<script>
			//点击刷新验证码
			$("#verifyImg").on("click", function() {
				$("#verifyImg").attr("src", "./verifyImg");
			});
		</script>
	</body>

</html>