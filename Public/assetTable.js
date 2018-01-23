$(function(){
	$.ajax(
		{
			url:"/ITCenter/index.php/Home/AssetTable/getAssetTableTitleData",
			type:'post',
			dataType:'json',
			success:function(data){
				var colData = [];
				colData[0] = {'field':'type','title':'类型','align':'center','width':'7%'};
				colData[1] = {'field':'brand','title':'品牌','align':'center','width':'7%'};
				var index = 2;
				for (k in data){
					colData[index] = {'field':'field'+data[k]['year'],'title':data[k]['year']+'年','align':'center','width':'7%'};
					index++;
				}
				colData[index] = {'field':'sum','title':'合计','align':'center','width':'7%'};
				var columns = new Array();
				columns.push(colData);
				var gridCfg = {
					columns : columns,
					url : "/ITCenter/index.php/Home/AssetTable/getAssetTableData",
					onLoadSuccess : function(data){
						var mark = 1;
						for(var i=1; i<data.rows.length; i++){
							if(data.rows[i]['type']==data.rows[i-1]['type']){
								mark += 1;
								$(this).datagrid('mergeCells',{
									index:i+1-mark,
									field:'type',
									rowspan:mark
								})
							}else{
								mark=1;
							}
						}
					}
				};
				$('#cDatagrid').datagrid(gridCfg);
			},
			error:function(){
				
			}
		}
	);
})

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
	
	$.post("/ITCenter/index.php/Home/AssetTable/tableExport",conditions,function(result){
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