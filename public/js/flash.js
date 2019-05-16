function flash() {
    $('#flash').fadeIn(300).delay(5000).fadeOut(300);
}

function newFlash(params) {
    element = $("#flash").append("<div class='flash'>"+params+"</div>");
}