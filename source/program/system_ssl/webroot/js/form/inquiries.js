$(document).ready(function (){
  change_inquiry_type();

  $('#InquiryInquiryType').change(function(){
    change_inquiry_type();
  });
});

function change_inquiry_type() {
  var s='normal';

  if ($('#InquiryInquiryType').val() != 2) {
    $("#privateInfo").slideUp(s);
    $("#privateText").slideUp(s);
    return;
  }
    $("#privateInfo").slideDown(s);
    $("#privateText").slideDown(s);
}

function _disp(url) {
    if(!window.opener || window.opener.closed){
        document.location = url;
    }else{
        window.opener.location.href = url;
    }
}