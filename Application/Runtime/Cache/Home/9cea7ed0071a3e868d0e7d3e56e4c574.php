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
		
	<script type="text/javascript" src="/itcenter/Public/log.js"></script>

	<div class="easyui-panel" title="条件筛选" style="width:100%;padding:15px">
		<form id="sForm" method="post">
			<table cellpadding="5">
				<tr>
					<td>日志类型：</td>
					<td>
						<select id="sType" class="easyui-combobox" name="sType" style="width:200px;" panelHeight="auto" editable="false">
							<option value="">全部</option>
							<option value="1">配置</option>
							<option value="2">资产</option>
							<option value="3">人员</option>
						</select>
					</td>
					<td>记录日期(S)：</td>
					<td>
						<input id="sCreateDateS" class="easyui-datetimebox" style="width:200px" editable="false" data-options="sharedCalendar:'#calendar'">
					</td>
					<td>记录日期(E)：</td>
					<td>
						<input id="sCreateDateE" class="easyui-datetimebox" style="width:200px" editable="false" data-options="sharedCalendar:'#calendar'">
					</td>
					<td>
						<div>
							<a class="easyui-linkbutton" style="height:25px;padding:0px 5px" onclick="doSearch()">搜索</a>
							<a class="easyui-linkbutton" style="height:25px;padding:0px 5px" onclick="clearSearch()">清空</a>
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div id="calendar" class="easyui-calendar"></div>

	<table id="cDatagrid" title="日志列表" class="easyui-datagrid"
		url="<?php echo U('Log/getLogListData');?>" 
		toolbar="#toolbar"
		rownumbers="true" 
		fitColumns="true" 
		singleSelect="true"
		pageSize="20"
		pagination="true">
		<thead>
			<tr>
				<th data-options="field:'type',width:'5'">类型</th>
				<th data-options="field:'text',width:'85'">内容</th>
				<th data-options="field:'create_date',width:'10'">时间</th>
			</tr>
		</thead>
	</table>
	
	<div id='loadingDiv' style="position: absolute; z-index: 1000; top: 0px; left: 0px; width: 100%; height: 100%; background: white; text-align: center;">    
		<h1 style="top: 48%; position: relative;">    
			<font color="#15428B">努力加载中···</font>    
		</h1>    
	</div>

	</div>
</body>
</html>