function doSearch(){
	$('#cDatagrid').datagrid('reload',{
		sName: $('#sName').val(),
		sDepartment: $('#sDepartment').val(),
		sJob: $('#sJob').val(),
		sOfficePhone: $('#sOfficePhone').val(),
		sMobilePhone: $('#sMobilePhone').val()
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
		url:"/ITCenter/index.php/Home/User/tableImport",
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
		sName: $('#sName').val(),
		sDepartment: $('#sDepartment').val(),
		sJob: $('#sJob').val(),
		sOfficePhone: $('#sOfficePhone').val(),
		sMobilePhone: $('#sMobilePhone').val()
	};
	
	$.post("/ITCenter/index.php/Home/User/tableExport",conditions,function(result){
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

function newUser(){
	$('#aForm').form('clear');
	$('#aOperation').val('add');
	$('#dialog1').dialog('open').dialog('setTitle','添加人员');
}

function editUser(){
	var row = $('#cDatagrid').datagrid('getSelected');
	$.post("/ITCenter/index.php/Home/User/userEdit",row,function(result){
		if(result.success) {
			$('#aOperation').val('edit');
			$('#aForm').form('load',{
				aID:result.data['id'],
				aName:result.data['name'],
				aDepartment:result.data['department'],
				aJob:result.data['job'],
				aOfficePhone:result.data['office_phone'],
				aMobilePhone:result.data['mobile_phone']
			});
			$('#dialog1').dialog('open').dialog('setTitle','修改人员');
		} else {
			$.messager.show({
				title: '错误提示',
				msg: result.errorMsg
			});
		}
	});
}
	
function saveUser(){
	$.post("/ITCenter/index.php/Home/User/userSave",$('#aForm').serialize(),function(result){
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

function destroyUser(){
	var row = $('#cDatagrid').datagrid('getSelected');
	if (row){
		$.messager.confirm('操作提示','是否确定删除此项数据？',function(r){
			if (r){
				$.post('/ITCenter/index.php/Home/User/userDestroy',{id:row.id},function(result){
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