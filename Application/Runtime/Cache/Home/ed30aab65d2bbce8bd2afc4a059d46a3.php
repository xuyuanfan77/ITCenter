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
					<td>资产编号：</td>
					<td>
						<input id="sID" class="easyui-combobox" type="text" name="sID" style="width:200px;"
							valueField="id" 
							textField="id" 
							url="<?php echo U('Allocation/getIdData');?>">
					</td>
					<td>类型：</td>
					<td>
						<input id="sType" class="easyui-combobox" name="sType" style="width:200px"
							panelHeight="auto"
							valueField="id" 
							textField="option_name" 
							url="<?php echo U('Asset/getOptionData',array('type'=>1));?>">
					</td>
					<td>品牌：</td>
					<td>
						<input id="sBrand" class="easyui-combobox" name="sBrand" style="width:200px"
							valueField="id" 
							textField="option_name" 
							url="<?php echo U('Asset/getOptionData',array('type'=>2));?>">
					</td>
					<td>型号：</td>
					<td>
						<input id="sModel" class="easyui-textbox" type="text" name="sModel" style="width:200px"></input>
					</td>
					<td>接入网络：</td>
					<td>
						<input id="sNetWork" class="easyui-combobox" name="sNetWork" style="width:200px"
							panelHeight="auto"
							valueField="id" 
							textField="option_name" 
							url="<?php echo U('Asset/getOptionData',array('type'=>3));?>">
					</td>
					
				</tr>
				<tr>
					<td>设备来源：</td>
					<td>
						<input id="sSource" class="easyui-combobox" name="sSource" style="width:200px"
							panelHeight="auto"
							valueField="id" 
							textField="option_name" 
							url="<?php echo U('Asset/getOptionData',array('type'=>5));?>">
					</td>
					<td>资产状态：</td>
					<td>
						<input id="sState" class="easyui-combobox" name="sState" style="width:200px"
							panelHeight="auto"
							valueField="id" 
							textField="option_name" 
							url="<?php echo U('Asset/getOptionData',array('type'=>4));?>">
					</td>
					<td>购置日期(S)：</td>
					<td>
						<input id="sPurchaseDateS" class="easyui-datetimebox" style="width:200px" editable="false" data-options="sharedCalendar:'#cc'">
					</td>
					<td>购置日期(E)：</td>
					<td>
						<input id="sPurchaseDateE" class="easyui-datetimebox" style="width:200px" editable="false" data-options="sharedCalendar:'#cc'">
					</td>
					<td></td>
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
	
	<table id="dg" title="资产列表" class="easyui-datagrid"
		url="<?php echo U('Asset/getAssetData');?>" 
		toolbar="#toolbar"
		rownumbers="true" 
		fitColumns="true" 
		singleSelect="true"
		pageSize="20"
		pagination="true">
		<thead>
			<tr>
				<th data-options="field:'id',width:'80'">资产编号</th>
				<th data-options="field:'type',width:'80'">类型</th>
				<th data-options="field:'brand',width:'80'">品牌</th>
				<th data-options="field:'model',width:'80'">型号</th>
				<th data-options="field:'number',width:'80'">序列号</th>
				<th data-options="field:'network',width:'80'">接入网络</th>
				<th data-options="field:'source',width:'80'">设备来源</th>
				<th data-options="field:'state',width:'80'">资产状态</th>
				<th data-options="field:'purchase_date',width:'80'">购置日期</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newAsset()">添加</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editAsset()">修改</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyAsset()">删除</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:640px;height:390px;padding:10px 20px"
		closed="true" buttons="#dlg-buttons">
		<form id="fm" method="post">
			<table cellpadding="5">
				<tr>
					<td>ID号：</td>
					<td>
						<input id="aID" class="easyui-textbox" type="text" name="aID" style="width:200px;" data-options="required:true,missingMessage:'必填'"></input>
					</td>
					<td>类型：</td>
					<td>
						<input id="aType" class="easyui-combobox" name="aType" style="width:200px"
						editable="false"
						panelHeight="auto"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>1));?>"
						data-options="required:true,missingMessage:'必填'">
					</td>
					
					
				</tr>
				<tr>
					<td>品牌：</td>
					<td>
						<input id="aBrand" class="easyui-combobox" name="aBrand" style="width:200px"
						editable="false"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>2));?>">
					</td>
					<td>型号：</td>
					<td>
						<input id="aModel" class="easyui-textbox" type="text" name="aModel" style="width:200px"></input>
					</td>
					
				</tr>
				<tr>
					<td>序列号：</td>
					<td>
						<input id="aNumber" class="easyui-textbox" type="text" name="aNumber" style="width:200px"></input>
					</td>
					<td>接入网络：</td>
					<td>
						<input id="aNetWork" class="easyui-combobox" name="aNetWork" style="width:200px"
						editable="false"
						panelHeight="auto"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>3));?>">
					</td>
				</tr>
				<tr>
					<td>设备来源：</td>
					<td>
						<input id="aSource" class="easyui-combobox" name="aSource" style="width:200px"
						editable="false"  
						panelHeight="auto"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>5));?>">
					</td>
					<td>资产状态：</td>
					<td>
						<input id="aState" class="easyui-combobox" name="aState" style="width:200px"
						editable="false"
						panelHeight="auto"
						valueField="id" 
						textField="option_name" 
						url="<?php echo U('Asset/getOptionData',array('type'=>4));?>">
					</td>
				</tr>
				<tr>
					<td>购置日期：</td>
					<td>
						<input id="aPurchaseDate" class="easyui-datetimebox" name="aPurchaseDate" style="width:200px"  editable="false" data-options="sharedCalendar:'#cc',required:true,missingMessage:'必填'">
					</td>
					<td>
						<input id="aOperation" type="hidden" name="aOperation" value="">
					</td>
				</tr>
				<tr>
					<td>备注：</td>
					<td colspan="3">
						<input id="aRemark" class="easyui-textbox" name="aRemark" data-options="multiline:true" style="width:490px;height:100px;">
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveAsset()">保存</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">取消</a>
	</div>
	<div id="cc" class="easyui-calendar"></div>
	<div id='loadingDiv' style="position: absolute; z-index: 1000; top: 0px; left: 0px; width: 100%; height: 100%; background: white; text-align: center;">    
		<h1 style="top: 48%; position: relative;">    
			<font color="#15428B">努力加载中···</font>    
		</h1>    
	</div> 

	<script>
		$(function()  
		{     
			var curr_time=new Date();     
			var strDate=curr_time.getFullYear()+"-";     
			strDate +=curr_time.getMonth()+1+"-";     
			strDate +=curr_time.getDate()+"-";     
			strDate +=" "+curr_time.getHours()+":";     
			strDate +=curr_time.getMinutes()+":";     
			strDate +=curr_time.getSeconds();     
			$("#aUseDate").datetimebox("setValue",strDate);
		});  
	</script>
	<script>
	function doSearch(){
		$('#dg').datagrid('reload',{
			sID: $('#sID').val(),
			sType: $('#sType').val(),
			sBrand: $('#sBrand').val(),
			sModel: $('#sModel').val(),
			sNumber: $('#sNumber').val(),
			sNetWork: $('#sNetWork').val(),
			sSource: $('#sSource').val(),
			sState: $('#sState').val(),
			sPurchaseDateS: $('#sPurchaseDateS').val(),
			sPurchaseDateE: $('#sPurchaseDateE').val()
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
		function newAsset(){
			$('#fm').form('clear');
			$('#aOperation').val('add');
			$('#aID').textbox('enable');
			$('#dlg').dialog('open').dialog('setTitle','添加资产');
		}
	</script>
	<script>
		function editAsset(){
			var row = $('#dg').datagrid('getSelected');
			$.post("/ITCenter/index.php/Home/Asset/assetEdit",row,function(result){
				if(result.success) {
					$('#aOperation').val('edit');
					$('#fm').form('load',{
					    aID:result.data['id'],
					    aType:result.data['type'],
					    aBrand:result.data['brand'],
					    aModel:result.data['model'],
					    aPurchaseDate:result.data['purchase_date'],
						aNumber:result.data['number'],
					    aNetWork:result.data['network'],
					    aState:result.data['state'],
					    aSource:result.data['source'],
					    aRemark:result.data['remark']
					});
					$('#aID').textbox('disable');
					$('#dlg').dialog('open').dialog('setTitle','修改资产');
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
		function saveAsset(){
			$.post("/ITCenter/index.php/Home/Asset/assetSave",$('#fm').serialize(),function(result){
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
		function destroyAsset(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('操作提示','是否确定删除此项数据？',function(r){
					if (r){
						$.post('/ITCenter/index.php/Home/Asset/assetDestroy',{id:row.id},function(result){
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