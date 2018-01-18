<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>资产管理</title>
	
	<link rel="stylesheet" type="text/css" href="/itcenter/Public/easyUI/themes/default/easyui.css"/>
	<link rel="stylesheet" type="text/css" href="/itcenter/Public/easyUI/themes/icon.css"/>
	<link rel="stylesheet" type="text/css" href="/itcenter/Public/asset.css"/>
	<script type="text/javascript" src="/itcenter/Public/easyUI/jquery.min.js"></script>
	<script type="text/javascript" src="/itcenter/Public/easyUI/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="/itcenter/Public/easyUI/easyui-lang-zh_CN.js"></script>
	<script type="text/javascript" src="/itcenter/Public/common.js"></script>
</head>

<body class="easyui-layout">
	<div id="north" data-options="region:'north'" style="height:100px;">
		<h1 id="title">廉江市国税局固定资产管理系统</h1>
		
	</div>
	<div id="south" data-options="region:'south'" style="height:50px;"></div>
	<div data-options="region:'west'" title="目录" style="width:240px;">
		<ul class="easyui-tree">
			<li>
				<span>固定资产管理</span>
				<ul>
					<li>
						<span>资产管理</span>
						<ul>
							<li><a style="text-decoration:none" href="<?php echo U('Allocation/index');?>">配置列表</a></li>
							<li><a style="text-decoration:none" href="<?php echo U('Asset/index');?>">资产列表</a></li>
							<li><a style="text-decoration:none" href="<?php echo U('User/index');?>">人员列表</a></li>
						</ul>
					</li>
					<li>
						<span>资产报表</span>
						<ul>
							<li><a style="text-decoration:none" href="<?php echo U('AllocationTable/index');?>">配置报表</a></li>
							<li><a style="text-decoration:none" href="<?php echo U('AssetTable/index');?>">资产报表</a></li>
						</ul>
					</li>
					<li>
						<span><a style="text-decoration:none" href="<?php echo U('Log/index');?>">操作日志</a></span>
					</li>
				</ul>
				
			</li>
			<li>
				<span>系统管理</span>
				<ul>
					<li>
						<span><a style="text-decoration:none" href="<?php echo U('Index/logout');?>">退出</a></span>
					</li>
				</ul>
			</li>
		</ul>
	</div>
	<div data-options="region:'center'" style="border:0px">
		
	<script type="text/javascript" src="/itcenter/Public/user.js"></script>
	<div class="easyui-panel" title="条件筛选" style="width:100%;padding:15px">
		<form id="sForm" method="post">
			<table cellpadding="5">
				<tr>
					<td>姓名：</td>
					<td>
						<input id="sName" class="easyui-combobox" type="text" name="sName"
						valueField="id" 
						textField="name" 
						url="<?php echo U('User/getNameData');?>">
					</td>
					<td>部门：</td>
					<td>
						<input id="sDepartment" class="easyui-combobox" name="sDepartment"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('User/getOptionData',array('type'=>6));?>">
					</td>
					<td>职务：</td>
					<td>
						<input id="sJob" class="easyui-combobox" name="sJob"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('User/getOptionData',array('type'=>7));?>">
					</td>
					<td>办公电话：</td>
					<td>
						<input id="sOfficePhone" class="easyui-textbox" type="text" name="sOfficePhone"></input>
					</td>
					<td>移动电话：</td>
					<td>
						<input id="sMobilePhone" class="easyui-textbox" type="text" name="sMobilePhone"></input>
					</td>
					<td>
						<div>
							<a class="easyui-linkbutton" style="height:25px;padding:0px 5px" onclick="doSearch()">搜索</a>
							<a class="easyui-linkbutton" style="height:25px;padding:0px 5px" onclick="clearSearch()">清空</a>
							<a class="easyui-linkbutton" style="height:25px;padding:0px 5px" onclick="doImport()">导入</a>
							<a class="easyui-linkbutton" style="height:25px;padding:0px 5px" onclick="doExport()">导出</a>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
	
	<table id="cDatagrid" title="人员列表" class="easyui-datagrid"
		url="<?php echo U('User/getUserListData');?>" 
		toolbar="#toolbar"
		rownumbers="true" 
		fitColumns="true" 
		singleSelect="true"
		pageSize="20"
		pagination="true">
		<thead>
			<tr>
				<th data-options="field:'name',width:'80'">姓名</th>
				<th data-options="field:'department',width:'80'">部门</th>
				<th data-options="field:'job',width:'80'">职务</th>
				<th data-options="field:'office_phone',width:'80'">办公电话</th>
				<th data-options="field:'mobile_phone',width:'80'">移动电话</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">添加</a>
		<a class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">修改</a>
		<a class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">删除</a>
	</div>
	
	<!-- 添加对话框 -->
	<div id="dialog1" class="easyui-dialog" style="width:640px;height:210px;padding:10px 20px" closed="true" buttons="#dialog1-buttons">
		<form id="aForm" method="post">
			<table cellpadding="5">
				<tr>
					<td>姓名：</td>
					<td>
						<input id="aName" class="easyui-combobox" type="text" name="aName" style="width:200px;" data-options="required:true,missingMessage:'必填'"></input>
					</td>
					<td>部门：</td>
					<td>
						<input id="aDepartment" class="easyui-combobox" name="aDepartment" style="width:200px"
						editable="false"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>6));?>"
						data-options="required:true,missingMessage:'必填'">
					</td>
				</tr>
				<tr>
					<td>职务：</td>
					<td>
						<input id="aJob" class="easyui-combobox" name="aJob" style="width:200px"
						editable="false"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>7));?>"
						data-options="required:true,missingMessage:'必填'">
					</td>
					<td>办公电话：</td>
					<td>
						<input id="aOfficePhone" class="easyui-textbox" type="text" name="aOfficePhone" style="width:200px"></input>
					</td>
					
				</tr>
				<tr>
					<td>移动电话：</td>
					<td>
						<input id="aMobilePhone" class="easyui-textbox" type="text" name="aMobilePhone" style="width:200px"></input>
					</td>
					<td>
						<input id="aOperation" type="hidden" name="aOperation" value="">
						<input id="aID" type="hidden" name="aID"></input>
					</td>
					<td></td>
				</tr>
			</table>
		</form>
	</div>
	<div id="dialog1-buttons">
		<a class="easyui-linkbutton" iconCls="icon-ok" onclick="saveUser()">保存</a>
		<a class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialog1').dialog('close')">取消</a>
	</div>
	
	<!-- 导出对话框 -->
	<div id="dialog2" class="easyui-dialog" style="width:300px;height:150px;padding:30px 20px" closed="true" buttons="#dialog2-buttons">
		<a>表格已经生成，请点击下载！</a>
	</div>
	<div id="dialog2-buttons">
		<a id="downLoadButton" class="easyui-linkbutton" iconCls="icon-ok">下载</a>
		<a class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialog2').dialog('close')">取消</a>
	</div>
	
	<!-- 导入对话框 -->
	<div id="dialog3" class="easyui-dialog" style="width:315px;height:148px;padding:25px 60px" closed="true" buttons="#dialog3-buttons">
		<form id="iForm" method="post"  enctype="multipart/form-data">
			<input id="userExcel" class="easyui-filebox" name="userExcel" data-options="buttonText:'浏览',prompt:'请选择xlsx文件'"/>
		</form>
	</div>
	<div id="dialog3-buttons">
		<a class="easyui-linkbutton" iconCls="icon-ok" onclick="tableImport()">导入</a>
		<a class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dialog3').dialog('close')">取消</a>
	</div>
	
	<div id='loadingDiv' style="position: absolute; z-index: 1000; top: 0px; left: 0px; width: 100%; height: 100%; background: white; text-align: center;">    
		<h1 style="top: 48%; position: relative;">努力加载中···</h1>    
	</div>

	</div>
</body>
</html>