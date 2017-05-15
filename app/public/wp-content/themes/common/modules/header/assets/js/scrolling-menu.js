(function($){

    $(document).ready(function(){
        $('.main-header').stickit({scope: StickScope.Document, top: 0});
        $('#profile-menu').on('show.bs.modal', function (e) {
            if (window.innerWidth >= 768) {
                return e.preventDefault();
            }
        })
    });

})(jQuery);