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
</head>

<body class="easyui-layout">
	<div id="north" data-options="region:'north'" style="height:100px;">
		<h1 id="title">固定资产管理系统</h1>
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
							<li><a style="text-decoration:none" href="<?php echo U('Asset/allocation');?>">配置列表</a></li>
							<li><a style="text-decoration:none" href="<?php echo U('Asset/assetList');?>">资产列表</a></li>
							<li><a style="text-decoration:none" href="<?php echo U('Asset/userList');?>">人员列表</a></li>
						</ul>
					</li>
					<li>
						<span>资产报表</span>
						<ul>
							<li>配置报表</li>
							<li>资产报表</li>
							<li>人员报表</li>
						</ul>
					</li>
					<li>
						<span><a style="text-decoration:none" href="<?php echo U('Asset/logList');?>">资产日志</a></span>
					</li>
					<li>
						<span>选项设置</span>
					</li>
				</ul>
			</li>
		</ul>
	</div>
	<div data-options="region:'center'" style="border:0px">
		
	<div class="easyui-panel" title="条件筛选" style="width:100%;padding:15px">
		<form id="ff" method="post">
			<table cellpadding="5">
				<tr>
					<td>姓名：</td>
					<td>
						<input id="sName" class="easyui-combobox" type="text" name="sName" style="width:200px;"
						valueField="id" 
						textField="name" 
						url="<?php echo U('User/getNameData');?>">
					</td>
					<td>部门：</td>
					<td>
						<input id="sDepartment" class="easyui-combobox" name="sDepartment" style="width:200px"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('User/getOptionData',array('type'=>6));?>">
					</td>
					<td>职务：</td>
					<td>
						<input id="sJob" class="easyui-combobox" name="sJob" style="width:200px"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('User/getOptionData',array('type'=>7));?>">
					</td>
					<td>办公电话：</td>
					<td>
						<input id="sOfficePhone" class="easyui-textbox" type="text" name="sOfficePhone" style="width:200px"></input>
					</td>
					<td>移动电话：</td>
					<td>
						<input id="sMobilePhone" class="easyui-textbox" type="text" name="sMobilePhone" style="width:200px"></input>
					</td>
					<td>
						<div>
							<a href="#" class="easyui-linkbutton" style="width:66px;height:25px;" onclick="doSearch()">搜索</a>
							<a href="#" class="easyui-linkbutton" style="width:66px;height:25px;" onclick="clearSearch()">清空</a>
							<a href="#" class="easyui-linkbutton" style="width:66px;height:25px;" onclick="doSearch()">导出</a>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
	
	<table id="dg" title="人员列表" class="easyui-datagrid"
		url="<?php echo U('User/getUserData');?>" 
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
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">添加</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">修改</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">删除</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:640px;height:210px;padding:10px 20px"
		closed="true" buttons="#dlg-buttons">
		<form id="fm" method="post">
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
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveUser()">保存</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">取消</a>
	</div>
	<div id='loadingDiv' style="position: absolute; z-index: 1000; top: 0px; left: 0px; width: 100%; height: 100%; background: white; text-align: center;">    
		<h1 style="top: 48%; position: relative;">    
			<font color="#15428B">努力加载中···</font>    
		</h1>    
	</div> 

	<script>
	function doSearch(){
		$('#dg').datagrid('reload',{
			sName: $('#sName').val(),
			sDepartment: $('#sDepartment').val(),
			sJob: $('#sJob').val(),
			sOfficePhone: $('#sOfficePhone').val(),
			sMobilePhone: $('#sMobilePhone').val()
		});
	}
	</script>
	<script>
	function clearSearch(){
		$('#ff').form('clear');
		doSearch();
	}
	</script>
	<script>
		function newUser(){
			$('#fm').form('clear');
			$('#aOperation').val('add');
			$('#dlg').dialog('open').dialog('setTitle','添加人员');
		}
	</script>
	<script>
		function editUser(){
			var row = $('#dg').datagrid('getSelected');
			$.post("/ITCenter/index.php/Home/User/userEdit",row,function(result){
				if(result.success) {
					$('#aOperation').val('edit');
					$('#fm').form('load',{
					    aID:result.data['id'],
					    aName:result.data['name'],
					    aDepartment:result.data['department'],
					    aJob:result.data['job'],
					    aOfficePhone:result.data['office_phone'],
						aMobilePhone:result.data['mobile_phone']
					});
					$('#dlg').dialog('open').dialog('setTitle','修改人员');
				} else {
					$.messager.show({
						title: '错误提示',
						msg: result.errorMsg
					});
				}
			});
		}
	</script>
	<script>	
		function saveUser(){
			$.post("/ITCenter/index.php/Home/User/userSave",$('#fm').serialize(),function(result){
				if(result.success) {
					$('#dg').datagrid('reload');
					$('#dlg').dialog('close');
					
				} else {
					$.messager.show({
						title: '错误提示',
						msg: result.errorMsg
					});
				}
			});

		}
	</script>
	<script>
		function destroyUser(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('操作提示','是否确定删除此项数据？',function(r){
					if (r){
						$.post('/ITCenter/index.php/Home/User/userDestroy',{id:row.id},function(result){
							if (result.success){
								$('#dg').datagrid('reload');
							} else {
								$.messager.show({
									title: '错误提示',
									msg: result.errorMsg
								});
							}
						},'json');
					}
				});
			}
		}
	</script>
	
	<script type="text/javascript">    
		function closeLoading() {    
			$("#loadingDiv").fadeOut("normal", function () {    
				$(this).remove();    
			});    
		}    
		
		var no;    
		$.parser.onComplete = function () {    
			if (no) clearTimeout(no);    
			no = setTimeout(closeLoading, 1000);    
		}            
	</script>

	</div>
</body>
</html>