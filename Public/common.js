$.parser.onComplete = function() {
	$("#loadingDiv").fadeOut("normal", function () {    
		$(this).remove();    
	}); 
}