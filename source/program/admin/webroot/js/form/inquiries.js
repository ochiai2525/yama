$(document).ready(function (){
  change_inquiry_type();

  $('#InquiryInquiryType').change(function(){
    change_inquiry_type();
  });
});

function change_inquiry_type() {
  var s='normal';

  if ($('#InquiryInquiryType').val() != 2) {
    $("#privateInfo").hide();
    $("#privateText").hide();
    return;
  }
    $("#privateInfo").show();
    $("#privateText").show();
}
