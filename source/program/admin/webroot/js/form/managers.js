$(document).ready(function (){
  enableRadio();
  $('input[@name="data[Admin][admintype]"]').click(function(){
    enableRadio();
  });

});

function enableRadio() {
    if ($('input[@name="data[Admin][admintype]"]:checked').val() == "2") {
      $('input[@id^="AdminAuthMenuStatus:"]').each(function(){
        $(this).attr({
         disabled: ""
        });
      });
    } else {
      $('input[@id^="AdminAuthMenuStatus:"]').each(function(){
        $(this).attr({
         disabled: "disabled"
        });
      });
    }
}
