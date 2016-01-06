
var yuga = {
	preloader: {
		loadedImages: [],
		load: function (url){
			var img = this.loadedImages;
			var l = img.length;
			img[l] = new Image();
			img[l].src = url;
		}
	}
};

$(function(){
	
	$('.rollover img, .rollover').each(function(){
		this.originalSrc = $(this).attr('src');
		this.rolloverSrc = this.originalSrc.replace(/(\.gif|\.jpg|\.png)/, "_ov$1");
		yuga.preloader.load(this.rolloverSrc);
	}).hover(function(){
		$(this).attr('src',this.rolloverSrc);
	},function(){
		$(this).attr('src',this.originalSrc);
	});
	       
});


$(function(){
	
	$('img.message-logo-swap01').each(function(){
		this.originalSrc = $("#message_logo360").attr('src');
		this.rolloverSrc = this.originalSrc.replace(/(\.gif|\.jpg|\.png)/, "_ov01$1");
		yuga.preloader.load(this.rolloverSrc);
	}).hover(function(){
		$("#message_logo360").attr('src',this.rolloverSrc);
	},function(){
		$("#message_logo360").attr('src',this.originalSrc);
	});
		       
});

$(function(){
	
	$('img.message-logo-swap02').each(function(){
		this.originalSrc = $("#message_logo360").attr('src');
		this.rolloverSrc = this.originalSrc.replace(/(\.gif|\.jpg|\.png)/, "_ov02$1");
		yuga.preloader.load(this.rolloverSrc);
	}).hover(function(){
		$("#message_logo360").attr('src',this.rolloverSrc);
	},function(){
		$("#message_logo360").attr('src',this.originalSrc);
	});
	       
});

$(function(){
	
	$('img.message-logo-swap03').each(function(){
		this.originalSrc = $("#message_logo360").attr('src');
		this.rolloverSrc = this.originalSrc.replace(/(\.gif|\.jpg|\.png)/, "_ov03$1");
		yuga.preloader.load(this.rolloverSrc);
	}).hover(function(){
		$("#message_logo360").attr('src',this.rolloverSrc);
	},function(){
		$("#message_logo360").attr('src',this.originalSrc);
	});
	       
});

$(function(){
   $('.pagetop a').click(function(){
　　$('#container').ScrollTo(1000, 'easeout');
　　return false;
   });
});

