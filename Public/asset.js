$(function(){     
		var curr_time=new Date();     
		var strDate=curr_time.getFullYear()+"-";     
		strDate +=curr_time.getMonth()+1+"-";     
		strDate +=curr_time.getDate()+"-";     
		strDate +=" "+curr_time.getHours()+":";     
		strDate +=curr_time.getMinutes()+":";     
		strDate +=curr_time.getSeconds();     
		$("#aUseDate").datetimebox("setValue",strDate);
});  

function doSearch(){
	$('#cDatagrid').datagrid('reload',{
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

function clearSearch(){
	$('#sForm').form('clear');
	doSearch();
}

function doImport(){
	$('#dialog3').dialog('open').dialog('setTitle','导入表格');
}

function tableImport(){
	$('#iForm').form('submit', {
		url:"/ITCenter/index.php/Home/Asset/tableImport",
		success:function(data){
			if(data=='error_fileType'){
				$.messager.show({
					title: '错误提示',
					msg: '上传文件后缀不是xlsx！'
				});
			}else if(data=='error_fileUpload'){
				$.messager.show({
					title: '错误提示',
					msg: '上传文件失败！'
				});
			}else if(data=='error_writeMysql'){
				$.messager.show({
					title: '错误提示',
					msg: '数据写库失败！'
				});
			}else if(data=='error_fileEmpty'){
				$.messager.show({
					title: '错误提示',
					msg: '请选择上传的文件！'
				});
			}else{
				$('#cDatagrid').datagrid('reload');
				$.messager.show({
					title: '错误提示',
					msg: '成功导入'+data+'条数据！'
				});
				
			}
			$('#dialog3').dialog('close');
		}
	});
}

function doExport(){
	var conditions = {
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
	};
	
	$.post("/ITCenter/index.php/Home/Asset/tableExport",conditions,function(result){
		if(result.success) {
			$('#downLoadButton').attr("href","http://localhost/itcenter/ExpImp/Export/"+result.fileName); 
			$('#dialog2').dialog('open').dialog('setTitle','下载表格');
		} else {
			$.messager.show({
				title: '错误提示',
				msg: result.errorMsg
			});
		}
	});
}

function newAsset(){
	$('#aForm').form('clear');
	$('#aOperation').val('add');
	$('#aID').textbox('enable');
	$('#dialog1').dialog('open').dialog('setTitle','添加资产');
}

function editAsset(){
	var row = $('#cDatagrid').datagrid('getSelected');
	$.post("/ITCenter/index.php/Home/Asset/assetEdit",row,function(result){
		if(result.success) {
			$('#aOperation').val('edit');
			$('#aForm').form('load',{
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
			$('#dialog1').dialog('open').dialog('setTitle','修改资产');
		} else {
			$.messager.show({
				title: '错误提示',
				msg: result.errorMsg
			});
		}
	});
}

function saveAsset(){
	$('#aID').textbox('enable');
	$.post("/ITCenter/index.php/Home/Asset/assetSave",$('#aForm').serialize(),function(result){
		if(result.success) {
			$('#cDatagrid').datagrid('reload');
			$('#dialog1').dialog('close');
		} else {
			$.messager.show({
				title: '错误提示',
				msg: result.errorMsg
			});
		}
	});

}

function destroyAsset(){
	var row = $('#cDatagrid').datagrid('getSelected');
	if (row){
		$.messager.confirm('操作提示','是否确定删除此项数据？',function(r){
			if (r){
				$.post('/ITCenter/index.php/Home/Asset/assetDestroy',{id:row.id},function(result){
					if (result.success){
						$('#cDatagrid').datagrid('reload');
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

$.parser.onComplete = function() {
	$("#loadingDiv").fadeOut("normal", function () {    
		$(this).remove();    
	}); 
}