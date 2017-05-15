jQuery(document).ready(function($){
    var searchBarSelector = $('.search-bar');
    var userBarSelector = $('.user-bar');
    var mobileMenuSelector = $('.mobile-menu');
    setSearchPlaceholder();
    setSearchTopPosition();
    triggerSearchMenu();
    triggerMobileMenu();

    $(window).resize(function(){
        setSearchTopPosition();
    });

    function triggerMobileMenu() {
        $('.menu-bar .navbar-toggle').on('click', function(event){
            event.preventDefault();
            mobileMenuSelector.toggleClass('opened');
        });
    }

    function triggerSearchMenu() {
        $('.search-button a').on('click', function(event){
            event.preventDefault();
            searchBarSelector.addClass('is-visible');
        });
        $('.close-button, .search-bar').on('click', function(event){
            if( $(event.target).is('.close-button') || $(event.target).is('.search-bar') ) {
                event.preventDefault();
                searchBarSelector.removeClass('is-visible');
            }
        });
        $(document).keyup(function(event){
            if(event.which=='27'){
                searchBarSelector.removeClass('is-visible');
            }
        });
    }

    function setSearchPlaceholder() {
        $('.searchform input[type="text"]').attr('placeholder', 'SØKE SYSLA');
    }

    function setSearchTopPosition() {
        searchBarSelector.css('top', userBarSelector.offset().top + userBarSelector.outerHeight());
    }
});