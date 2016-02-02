function hasFlash(){
	var hasFlash = false;
	try {
		var fo = new ActiveXObject('ShockwaveFlash.ShockwaveFlash');
		if(fo) hasFlash = true;
	}catch(e){
		if(navigator.mimeTypes ["application/x-shockwave-flash"] != undefined) hasFlash = true;
	}
	return hasFlash;
}

$(function(){
	if (!hasFlash()){
		$('#flash').css({'width':'904px', 'height':'430px'});
		$("#flash").empty();
		$.getScript("common/js/swiffyobject.js", function(){
			$script = $('<script>').text('var stage=new swiffy.Stage(document.getElementById("flash"),swiffyobject,{});stage.start();');
			$('#flash').after($script);
		});
	}
});
