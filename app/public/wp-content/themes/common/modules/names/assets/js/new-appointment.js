(function ($){

$(document).ready(function() {
    newAppointment();
    checkFile();
});

function newAppointment(){
    if(isSetCookies()){
        showPopup();
        removeCookies();
        removePopup();
    }
}

function isSetCookies(){
    var cookies = $.cookie('nytt_om_nawn_created');
    return (cookies) ? true : false;
}

function showPopup(){
    $(".new-appointment-pop-up").removeClass('hidden');
}

function removeCookies() {
    $.removeCookie('nytt_om_nawn_created', { path: '/' });
}

function removePopup(){
    setTimeout(function() { hidePopup(); }, 8000);
}

function hidePopup(){
    $(".new-appointment-pop-up").addClass('hidden');
}

function checkFile() {
    $('#names_add_new_form input[type=submit]').click(function(e) {
        if( document.getElementById("user-avatar").files.length == 0 ){
            showNoFilePopup(hideNoFilePopupOnTimeout);
        }
    });
}

function showNoFilePopup(hideNoFilePopupOnTimeout) {
    document.getElementById("no-file").className = "";
    hideNoFilePopupOnTimeout();
}

function hideNoFilePopup() {
    document.getElementById("no-file").className = "invisible";
}

function hideNoFilePopupOnTimeout() {
    setTimeout(hideNoFilePopup, 5000);
}

})(jQuery);