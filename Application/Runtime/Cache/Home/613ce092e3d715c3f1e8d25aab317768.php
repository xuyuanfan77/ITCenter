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
							<li>资产列表</li>
						</ul>
					</li>
					<li>
						<span>资产报表</span>
						<ul>
							<li>库存报表</li>
							<li>配置报表</li>
						</ul>
					</li>
					<li>
						<span>资产日志</span>
					</li>
					<li>
						<span>选项设置</span>
						<ul>
							<li>类型设置</li>
							<li>品牌设置</li>
							<li>使用部门</li>
							<li>网络情况</li>
							<li>使用状态</li>
							<li>设备来源</li>
						</ul>
					</li>
				</ul>
			</li>
		</ul>
	</div>
	<div data-options="region:'center',title:'内容'">
		
	<form id="ff" method="post">
		<table cellpadding="5">
			<tr>
				<td>类型：</td>
				<td>
					<select class="easyui-combobox" name="language" style="width:200px">
						<option value="ar">主机</option>
						<option value="bg">显示器</option>
						<option value="ca">扫描仪</option>
					</select>
				</td>
				<td>品牌：</td>
				<td>
					<select class="easyui-combobox" name="language" style="width:200px">
						<option value="ar">海尔</option>
						<option value="bg">联想</option>
						<option value="ca">清华同方</option>
					</select>
				</td>
				<td>型号：</td>
				<td>
					<input class="easyui-textbox" type="text" name="email" style="width:200px"></input>
				</td>
				<td>购置日期(S)：</td>
				<td>
					<input class="easyui-datebox" style="width:200px" data-options="sharedCalendar:'#cc'">
				</td>
				<td>购置日期(E)：</td>
				<td>
					<input class="easyui-datebox" style="width:200px" data-options="sharedCalendar:'#cc'">
				</td>
				<div id="cc" class="easyui-calendar"></div>
			</tr>
			<tr>
				<td>序列号：</td>
				<td><input class="easyui-textbox" type="text" name="email" style="width:200px"></input></td>
				<td>网络情况：</td>
				<td>
					<select class="easyui-combobox" name="language" style="width:200px">
						<option value="ar">内网</option>
						<option value="bg">外网</option>
					</select>
				</td>
				<td>使用状态：</td>
				<td>
					<select class="easyui-combobox" name="language" style="width:200px">
						<option value="ar">在用</option>
						<option value="bg">备用</option>
					</select>
				</td>
				
				<td>领用日期(S)：</td>
				<td>
					<input class="easyui-datebox" data-options="sharedCalendar:'#cc'" style="width:200px">
				</td>
				<td>领用日期(E)：</td>
				<td>
					<input class="easyui-datebox" data-options="sharedCalendar:'#cc'" style="width:200px">
				</td>
				<div id="cc" class="easyui-calendar"></div>
			</tr>
			<tr>
				<td>设备来源：</td>
				<td>
					<select class="easyui-combobox" name="language" style="width:200px">
						<option value="ar">本级采购</option>
						<option value="bg">上级采购</option>
					</select>
				</td>
				<td>使用人：</td>
				<td><input class="easyui-textbox" type="text" name="email" style="width:200px"></input></td>
				<td>使用部门：</td>
				<td>
					<select class="easyui-combobox" name="language" style="width:200px">
						<option value="ar">信息中心</option>
						<option value="bg">征收管理</option>
					</select>
				</td>
				<td></td>
				<td></td>
				<td></td>
				<td>
					<button type="submit" class="easyui-linkbutton" style="width:100px;height:25px;">搜索</button>
					<button type="submit" class="easyui-linkbutton" style="width:100px;height:25px;">导出</button>
				</td>
			</tr>
		</table>
	</form>

	<table id="dg" title="列表" class="easyui-datagrid"
		url="<?php echo U('Asset/getAssetData');?>" 
		toolbar="#toolbar"
		rownumbers="true" fitColumns="true" singleSelect="true" method="get">
		<thead>
			<tr>
				<th data-options="field:'id',width:'80'">类型</th>
				
				<th data-options="field:'type',width:'80'">类型</th>
				<th data-options="field:'brand',width:'80'">品牌</th>
				<th data-options="field:'model',width:'80'">型号</th>
				<th data-options="field:'serial_number',width:'80'">序列号</th>
				<th data-options="field:'purchase_date',width:'80'">购置日期</th>
				<th data-options="field:'network_status',width:'80'">网络情况</th>
				<th data-options="field:'use_state',width:'80'">使用状态</th>
				<!--th field="user_name" width="10%">使用人</th>
				<th field="user_department" width="10%">使用部门</th>
				<th field="operation" width="10%">操作</th-->
				<th data-options="field:'equipment_source',width:'80'">使用人</th>
				<th data-options="field:'remark',width:'80'">使用部门</th>
				<th data-options="field:'create_date',width:'80'">操作</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<a href="#" class="easyui-linkbutton" iconCls="icon-add" plain="true" onclick="newUser()">添加</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-edit" plain="true" onclick="editUser()">修改</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-remove" plain="true" onclick="destroyUser()">删除</a>
	</div>
	
	<div id="dlg" class="easyui-dialog" style="width:640px;height:430px;padding:10px 20px"
		closed="true" buttons="#dlg-buttons">
		<form id="fm" method="post">
			<table cellpadding="5">
				<tr>
					<td>类型：</td>
					<td>
						<select class="easyui-combobox" name="type" style="width:200px">
							<option value="ar">主机</option>
							<option value="bg">显示器</option>
							<option value="ca">扫描仪</option>
						</select>
					</td>
					<td>品牌：</td>
					<td>
						<select class="easyui-combobox" name="brand" style="width:200px">
							<option value="ar">海尔</option>
							<option value="bg">联想</option>
							<option value="ca">清华同方</option>
						</select>
					</td>
					
				</tr>
				<tr>
					<td>型号：</td>
					<td>
						<input class="easyui-textbox" type="text" name="model" style="width:200px"></input>
					</td>
					<td>购置日期：</td>
					<td>
						<input class="easyui-datebox" style="width:200px" name="purchase_date" data-options="sharedCalendar:'#cc'">
					</td>
					<div id="cc" class="easyui-calendar"></div>
				</tr>
				<tr>
					<td>序列号：</td>
					<td>
						<input class="easyui-textbox" type="text" name="serial_number" style="width:200px"></input>
					</td>
					<td>网络情况：</td>
					<td>
						<select class="easyui-combobox" name="network_status" style="width:200px">
							<option value="ar">内网</option>
							<option value="bg">外网</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>使用状态：</td>
					<td>
						<select class="easyui-combobox" name="use_state" style="width:200px">
							<option value="ar">在用</option>
							<option value="bg">备用</option>
						</select>
					</td>
					
					<td>领用日期：</td>
					<td>
						<input class="easyui-datebox" name="use_date" data-options="sharedCalendar:'#cc'" style="width:200px">
					</td>
					<div id="cc" class="easyui-calendar"></div>
				</tr>
				<tr>
					<td>设备来源：</td>
					<td>
						<select class="easyui-combobox" name="equipment_source" style="width:200px">
							<option value="ar">本级采购</option>
							<option value="bg">上级采购</option>
						</select>
					</td>
					<td>使用人：</td>
					<td><input class="easyui-textbox" type="text" name="user_name" style="width:200px"></input></td>
				</tr>
				<tr>
					<td>使用部门：</td>
					<td>
						<select class="easyui-combobox" name="user_department" style="width:200px">
							<option value="ar">信息中心</option>
							<option value="bg">征收管理</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>备注：</td>
					<td colspan="3">
						<input class="easyui-textbox" name="remark" data-options="multiline:true" style="width:490px;height:100px;">
					</td>
				</tr>
			</table>
		</form>
	</div>
	<div id="dlg-buttons">
		<a href="#" class="easyui-linkbutton" iconCls="icon-ok" onclick="saveUser()">保存</a>
		<a href="#" class="easyui-linkbutton" iconCls="icon-cancel" onclick="javascript:$('#dlg').dialog('close')">取消</a>
	</div>
	
	<script>
		function newUser(){
			$('#dlg').dialog('open').dialog('setTitle','添加固定资产');
			$('#fm').form('clear');
			url = '/ITCenter/index.php/Home/Asset/assetAdd';
		}
	</script>
	<script>	
		function saveUser(){
			$.ajax({  
				type:'post',
				dataType:'json',
				data:'',  
				url:url,
				success : function(data) {
					if(data == '登录成功！') {
						location.href=document.referrer;
					} else {
						alert(data);
					}
				},  
				error : function() {  
					alert('响应异常！');
				}  
			}); 
		}
	</script>

	</div>
</body>
</html>