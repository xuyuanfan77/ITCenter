function doSearch(){
	$('#cDatagrid').datagrid('reload',{
		sType: $('#sType').val(),
		sCreateDateS: $('#sCreateDateS').val(),
		sCreateDateE: $('#sCreateDateE').val()
	});
}

function clearSearch(){
	$('#sForm').form('clear');
	doSearch();
}

$.parser.onComplete = function() {
	$("#loadingDiv").fadeOut("normal", function () {    
		$(this).remove();    
	}); 
}