(function ($){

$(document).ready(function() {
    representImage();
    bindImageChange();
});

function representImage(){
    var image = $('#avatar-img');
    (image.attr('src')) ? image.show() : image.hide();
}

function bindImageChange(){
    $("#user-avatar").change(function(){
        readImage(this);
    });
}

function readImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#avatar-img').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
    $('#avatar-img').show();
}

})(jQuery);