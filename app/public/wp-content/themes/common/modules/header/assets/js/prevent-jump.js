(function($){
    $(document).ready(function(){
        $('a[data-toggle="modal"], a[data-dismiss="modal"], .main-header a[href="#"]').click(function (e) {
            e.preventDefault();
        });
    });
})(jQuery);