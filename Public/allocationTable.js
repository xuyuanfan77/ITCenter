$(function(){
	$.ajax(
		{
			url:"/ITCenter/index.php/Home/AllocationTable/getAllocationTableTitleData",
			type:'post',
			dataType:'json',
			data:{
				
			},
			success:function(data){
				var colData = [];
				colData[0] = {'field':'department','title':'部门','align':'center','width':'15%'};
				var index = 1;
				for (k in data){
					colData[index] = {'field':'field'+data[k]['id'],'title':data[k]['option_name'],'align':'center','width':'6%'};
					index++;
				}
				var columns = new Array();
				columns.push(colData);
				var gridCfg = {
					columns : columns,
					url : "/ITCenter/index.php/Home/AllocationTable/getAllocationTableData",
				};
				$('#cDatagrid').datagrid(gridCfg);
			},
			error:function(){
				
			}
		}
	);
})

function doExport(){
	var conditions = {};
	
	$.post("/ITCenter/index.php/Home/AllocationTable/tableExport",conditions,function(result){
		if(result.success) {
			$('#downLoadButton').attr("href","http://localhost/itcenter/ExpImp/Export/"+result.fileName); 
			$('#dialog1').dialog('open').dialog('setTitle','下载表格');
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