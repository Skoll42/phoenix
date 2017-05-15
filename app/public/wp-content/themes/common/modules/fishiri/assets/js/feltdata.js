(function ($){

    $( document ).ready(function() {
        countFelts();
        countFeltInvestSum();

        setCarouselHeight();

        $('#feltGallery').on('slide.bs.carousel', function(e) {
            var pos = $(e.relatedTarget).attr('item-id');
            setImageCounter(pos);
        });
        setImageCounter(1);
        showMore();
        showAll();
    });

    function setImageCounter(pos) {
        var total = $('.carousel-inner .item').length;
        $('#imagesCount').text(pos + ' / ' + total);
    }

    function setCarouselHeight() {
        var carousel = $('.carousel-inner');
        carousel.height(1);

        $('.item img', carousel).each(function() {
            var img = new Image();
            img.onload = function() {
                var carouselHeight = carousel.height();
                var resultHeight = (this.height > carouselHeight) ? this.height : carouselHeight;
                carousel.height(resultHeight);
            };
            img.src = this.src;
        });
    }

    function countFelts() {
        var feltCount = $('#oversiktTable').find('tbody tr:visible').length;
        $('.feltCounter').text(feltCount + ' felt');
    }

    function convertToNumber(num) {
        var number = parseFloat( num.replace( /[kr, " "]/g, '') );
        return isNaN(number) ? 0 : number;
    }

    function convertToCurrency(num) {
        return (num + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1 ");
    }

    function countFeltInvestSum() {
        var feltSum = 0;
        $('#oversiktTable').find('tbody tr:visible .feltInvests').each(function() {
            feltSum += convertToNumber($(this).text());
            $('.summaryRow .feltInvests').text("kr " + convertToCurrency(feltSum));
        });
    }

    function showMore() {
        $('.more').click(function(e){
            e.preventDefault();
            var items = $(this).parent().siblings('.articlesList').children('.hidden:lt(10)').removeClass('hidden');
        });
    }

    function showAll() {
        $('.all').click(function(e){
            e.preventDefault();
            var items = $(this).parent().siblings('.articlesList').children('.hidden').removeClass('hidden');
        });
    }

})(jQuery);