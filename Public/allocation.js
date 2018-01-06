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
		sPurchaseDateS: $('#sPurchaseDateS').val(),
		sPurchaseDateE: $('#sPurchaseDateE').val(),
		sUseDateS: $('#sUseDateS').val(),
		sUseDateE: $('#sUseDateE').val(),
		sName: $('#sName').val(),
		sDepartment: $('#sDepartment').val(),
		sState: $('#sState').val()
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
		url:"/ITCenter/index.php/Home/Allocation/tableImport",
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
		sPurchaseDateS: $('#sPurchaseDateS').val(),
		sPurchaseDateE: $('#sPurchaseDateE').val(),
		sUseDateS: $('#sUseDateS').val(),
		sUseDateE: $('#sUseDateE').val(),
		sName: $('#sName').val(),
		sDepartment: $('#sDepartment').val(),
		sState: $('#sState').val()
	};
	
	$.post("/ITCenter/index.php/Home/Allocation/tableExport",conditions,function(result){
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

function getAssetData(){
	var aAssetID = $("#aAssetID").textbox('getValue');
	$.post("/ITCenter/index.php/Home/Allocation/getAssetData",{'id':aAssetID},function(result){
		if(result.success) {
			$('#fm').form('load',{
				aType:result.data['type'],
				aBrand:result.data['brand'],
				aModel:result.data['model'],
				aNumber:result.data['number'],
				aNetWork:result.data['network'],
				aSource:result.data['source'],
				aState:result.data['state'],
				sPurchaseDate:result.data['purchase_date']
			});
		} else {
			$.messager.show({
				title: '错误提示',
				msg: result.errorMsg
			});
		}
	});
}

function getUserData(){
	var aName = $("#aName").combobox('getText');
	$.post("/ITCenter/index.php/Home/Allocation/getUserData",{'name':aName},function(result){
		if(result.success) {
			$('#fm').form('load',{
				aUserID:result.data['id'],
				aDepartment:result.data['department'],
				aJob:result.data['job'],
				aOfficePhone:result.data['office_phone'],
				aMobilePhone:result.data['mobile_phone']
			});
		} else {
			$.messager.show({
				title: '错误提示',
				msg: result.errorMsg
			});
		}
	});
}

function newAllocation(){
	$('#fm').form('clear');
	$('#aOperation').val('add');
	$('#dialog1').dialog('open').dialog('setTitle','添加资产配置');
}
	
function saveAllocation(){
	$('#aAssetID').textbox('enable');
	$.post("/ITCenter/index.php/Home/Allocation/allocationSave",$('#fm').serialize(),function(result){
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

function destroyAllocation(){
	var row = $('#cDatagrid').datagrid('getSelected');
	if (row){
		$.messager.confirm('操作提示','是否确定删除此项数据？',function(r){
			if (r){
				$.post('/ITCenter/index.php/Home/Allocation/allocationDestroy',{id:row.id},function(result){
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
		
function editAllocation(){
	$('#aAssetID').textbox('disable');
	var row = $('#cDatagrid').datagrid('getSelected');
	$.post("/ITCenter/index.php/Home/Allocation/allocationEdit",row,function(result){
		if(result.success) {
			$('#aOperation').val('edit');
			$('#fm').form('load',{
				aID:result.data['id'],
				aType:result.data['type'],
				aBrand:result.data['brand'],
				aModel:result.data['model'],
				aNumber:result.data['number'],
				aNetWork:result.data['network'],
				aSource:result.data['source'],
				aState:result.data['state'],
				sPurchaseDate:result.data['purchase_date'],
				aRemark:result.data['allocation_remark'],
				aName:result.data['name'],
				aDepartment:result.data['department'],
				aJob:result.data['job'],
				aOfficePhone:result.data['office_phone'],
				aMobilePhone:result.data['mobile_phone'],
				aUseDate:result.data['use_date'],
				aUserID:result.data['user_id'],
				aAssetID:result.data['asset_id']
			});
			$('#dialog1').dialog('open').dialog('setTitle','修改资产配置');
		} else {
			$.messager.show({
				title: '错误提示',
				msg: result.errorMsg
			});
		}
	});
}
  
$.parser.onComplete = function() {
	$("#loadingDiv").fadeOut("normal", function () {    
		$(this).remove();    
	}); 
}