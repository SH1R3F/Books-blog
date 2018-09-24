$(document).ready(function(){
  $("[placeholder]").focus(function(){
    $(this).attr("data-placeholder", $(this).attr("placeholder"));
    $(this).removeAttr("placeholder");
  }).blur(function(){
    $(this).attr("placeholder", $(this).attr("data-placeholder"));
    $(this).removeAttr("data-placeholder");
  });
  //Smooth scrolling with links
})
