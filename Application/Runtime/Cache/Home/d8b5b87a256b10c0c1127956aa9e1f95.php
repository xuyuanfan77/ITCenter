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
		
	<script type="text/javascript" src="/itcenter/Public/allocationTable.js"></script>

	<table id="cDatagrid" title="配置报表" class="easyui-datagrid"
		toolbar="#toolbar"
		rownumbers="true" 
		fitColumns="true" 
		singleSelect="true"></table>
	<div id="toolbar">
		<a class="easyui-linkbutton" iconCls="icon-redo" plain="true" onclick="newAsset()">导出</a>
		<a class="easyui-linkbutton" iconCls="icon-print" plain="true" onclick="editAsset()">打印</a>
	</div>
	
	<div id='loadingDiv' style="position: absolute; z-index: 1000; top: 0px; left: 0px; width: 100%; height: 100%; background: white; text-align: center;">    
		<h1 style="top: 48%; position: relative;">努力加载中···</h1>    
	</div>

	</div>
</body>
</html>