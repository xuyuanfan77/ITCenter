<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>固定资产管理系统</title>
	
	<link rel="stylesheet" type="text/css" href="/itcenter/Public/easyUI/themes/default/easyui.css"/>
	<link rel="stylesheet" type="text/css" href="/itcenter/Public/easyUI/themes/icon.css"/>
	<link rel="stylesheet" type="text/css" href="/itcenter/Public/index.css"/>
	<script type="text/javascript" src="/itcenter/Public/easyUI/jquery.min.js"></script>
	<script type="text/javascript" src="/itcenter/Public/easyUI/jquery.easyui.min.js"></script>
</head>

<body>
	<div id="head" style="width:100%;"><h1>固定资产管理系统</h1></div>
	<div id="center" class="easyui-panel" style="width:450px;height:300px;">
		<form id="ff" method="post" action="<?php echo U('Index/login');?>">
			<div id="div3">
				<input class="easyui-textbox" name="name" style="width:100%;height:40px;" data-options="label:'账号:',required:true">
			</div>
			<div id="div4">
				<input class="easyui-textbox" type="password" name="password" style="width:100%;height:40px;" data-options="label:'密码:',required:true">
			</div>
			<div style="text-align:center;">
				<button type="submit" class="easyui-linkbutton" style="width:120px;height:40px;">登陆</button>
				<a href="javascript:void(0)" class="easyui-linkbutton" onclick="clearForm()" style="width:120px;height:40px;">重置</a>
			</div>
		</form>
	</div>
	<script>
		function clearForm(){
			$('#ff').form('clear');
		}
	</script>
	<div id="foot" style="width:100%;">Copyright 2017.11 by 廉江国家税务局信息中心 All rights reserved.</div>
</body>
</html>