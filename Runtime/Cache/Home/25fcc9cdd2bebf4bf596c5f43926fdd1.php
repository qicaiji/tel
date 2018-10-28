<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta charset="utf-8" />
<link rel="stylesheet" type="text/css" href="/thinkphp/tel/Common/Common/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="/thinkphp/tel/Common/Common/css/telbook.css" />

	<link rel="stylesheet" type="text/css" href="/thinkphp/tel/Common/Common/css/controller/<?php echo (CONTROLLER_NAME); ?>.css" />

<title>通讯录</title>
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
                <th>姓名</th>
                <?php if(session('gids') < 5): ?><th>
                		<label>
                			<input type="checkbox" id="allbox" /> 群短信
                		</label>
                	</th><?php endif; ?>
                <th>部门</th>
				<th>职位</th>
                <th>更新时间</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($ulist)): $i = 0; $__LIST__ = $ulist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one): $mod = ($i % 2 );++$i;?><tr>
                    <td class="dropdown">
						
						<a href="#" data-toggle="dropdown"><?php echo ($one["realname"]); ?></a>
						<ul class="dropdown-menu">
							<li class="tels">V网：<?php echo ($one["vtel"]); ?></li>
							<li class="tels">手机号：<?php echo ($one["fulltel"]); ?></li>
							<li class="tels">办公室：<?php echo ($one["otel"]); ?></li>
							<li class="tels">家庭：<?php echo ($one["hometel"]); ?></li>
							<li class="tels">亲属：<?php echo ($one["familytel"]); ?></li>
							<li class="tels">邮箱/QQ：<?php echo ($one["mail"]); ?></li>
							<li class="tels">
								<?php if(session('gid') != 5): ?><a href="<?php echo U('edit',array('uid'=>$one['uid']));?>" class="btn btn-info">修改</a><?php endif; ?>
							</li>
						</ul>
					</td>
					<?php if(session('gids') < 5): ?><td>
	                		<label>
	                			<input type="checkbox" class="message" value="<?php echo ($one["realname"]); ?>,<?php echo ($one["fulltel"]); ?>,<?php echo ($one["dids"]); ?>,<?php echo ($one["jids"]); ?>" />
	                		</label>
	                	</td><?php endif; ?>
                    <td><?php echo ($one["dids"]); ?></td>
					<td><?php echo ($one["jids"]); ?></td>
                    <td><?php echo date('Y-m-d',$one['uptime']);?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    
    <?php if(session('gids') < 5): ?><div class="text-center">
	    	<a href="#" id="savelist" class="btn btn-info bottom10">添加到群短信</a> | 
	    	<a href="<?php echo U('message/getlist');?>" id="test2" class="btn btn-info bottom10" target="_blank">准备发短信</a> |
	    	<a href="#" id="dellist" class="btn btn-info bottom10">清空短信列表</a> | 
	    	<a href="<?php echo U('message/showmessagelog');?>" class="btn btn-info bottom10" target="_blank">查看短信日志</a>
	    </div><?php endif; ?>
    
    <div class="text-center h3"><?php echo ($page); ?></div>
    
    <div id="search">
        <form action="<?php echo U(ACTION_NAME);?>" method="post">
        	<div class="container-fluid">
        		<div class="row search">
        			<div class="col-xs-12 col-sm-3"></div>
        			<div class="col-xs-6 col-sm-3">
			            <select name="did">
			            	<option value="">部门/年级</option>
			                <?php if(is_array($searchdlist)): $i = 0; $__LIST__ = $searchdlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$done): $mod = ($i % 2 );++$i;?><option value="<?php echo ($done['did']); ?>"><?php echo ($done['dname']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>
					<div class="col-xs-6 col-sm-3">
						<select name="jid">
			            	<option value="">职位/职务</option>
			                <?php if(is_array($searchjlist)): $i = 0; $__LIST__ = $searchjlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$done): $mod = ($i % 2 );++$i;?><option value="<?php echo ($done['jid']); ?>"><?php echo ($done['jname']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						</select>
					</div>
				</div>
				
				<div class="row search">
					<div class="col-xs-3 col-sm-4"></div>
					<div class="col-xs-6 col-sm-4">
						<input type="text" name="content" placeholder="部分姓名或号码" />
	           		</div>
	           	</div>
	           	
	           	<div class="row search">
	           		<div class="col-xs-3 col-sm-4"></div>
					<div class="col-xs-6 col-sm-4">
	           			<input type="submit" value="查询" />
	           		</div>
				</div>
			</div>
        </form>
    </div>
    
    <div id="messages" class="hidden"><ul class="text-center"></ul></div>

</div>	  
    <div id="footer">
	Power By WSCC ：det@qq.com

</div>
    

<script type="text/javascript" src="/thinkphp/tel/Common/Common/js/jquery-2.2.3.js"></script></script>
<script type="text/javascript" src="/thinkphp/tel/Common/Common/js/bootstrap.js"></script></script>

<script type="text/javascript" src="/thinkphp/tel/Common/Common/js/telbook.js"></script>


<script>
	//全选 不全选
	$("#allbox").click(function(){
		if($(".message").is(":checked")){
			$(".message").prop("checked",false);
		}else{
			$(".message").prop("checked",true);
		}
	});
	
	//添加到列表
	$("#savelist").click(function(e){
		e.preventDefault();
		var telList = new Array();
		$("input.message:checked").each(function(){
			telList.push(this.value);
		});
		
		//console.log(telList);
		
		if(telList.length == 0){
			alert('发送列表是空的，请先添加群发号码列表');
			return false;
		}
		
		//ajax添加到session
		$.ajax({
			type:"POST",
			url:"<?php echo U('message/savelist');?>",
			data:"messages=" + encodeURIComponent(telList.join(";")),
			success:function(respose,state,xhr){
				alert('添加成功！去掉重复后，当前群发数量为：' + respose);
				//console.log(respose);
				changeButton(respose);
			}
		});
	});
	
	function changeButton(n){
		$("#savelist").text("添加到群短信("+ n + ")");
	}
	
	//清空列表
	$("#dellist").click(function(e){
		e.preventDefault();
		//删除session
		$.ajax({
			type:"GET",
			url:"<?php echo U('message/dellist');?>",
			success:function(respose,state,xhr){
				if(respose){
					alert('删除成功！');
					changeButton(0);
				}
			}
		});
	});
	
	function contains(a, e){
	    for(j=0;j<a.length;j++)if(a[j]==e)return true;
	    return false;
	}
	
</script>

</body>
</html>