$(document).ready(function() {
    $( "#flash" ).show().animate({
        left: "-=200"
      }, 200, function() {
        $('#flash').delay(5000).fadeOut(100);
      });
});