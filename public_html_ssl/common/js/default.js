
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
   $('.pagetop a').click(function(){
　　$('#container').ScrollTo(1000, 'easeout');
　　return false;
   });
});

$(function() {

	$('#confirm_img').click( function () {
		if(!document.getElementById('agree').checked){
		alert("下記の「プライバシーポリシー」に関する確認事項を必ずお読みください。\n内容を確認し、承諾される方は下の 「承諾する」を選択してください。");
		return false;
		} else {
			location.href="https://www.yamatame.com/index.do";
		}
	});


});
