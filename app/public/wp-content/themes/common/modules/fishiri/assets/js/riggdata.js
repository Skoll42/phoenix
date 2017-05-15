(function ($){

    $( document ).ready(function() {
        bindSectionExpand();
        bindShowHideAll();
        countRigs();
        countRigRateSum();

        setCarouselHeight();

        $('#riggGallery').on('slide.bs.carousel', function(e) {
            var pos = $(e.relatedTarget).attr('item-id');
            setImageCounter(pos);
        });
        setImageCounter(1);
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

    function bindSectionExpand() {
        $('.sectionInfo .header').click(function(event) {
            event.preventDefault();
            var section = $(this).parent();
            section.toggleClass('open');

            triggerTableResize();
        });
    }

    function triggerTableResize() {
        var tables = $('table.footable');
        tables.each(function() {
            $(this).trigger('footable_resize');
        });
    }

    function bindShowHideAll() {
        $('#showAll').click(function(event) {
            event.preventDefault();
            $('.sectionInfo').addClass('open');

            triggerTableResize();
        });

        $('#hideAll').click(function() {
            event.preventDefault();
            $('.sectionInfo').removeClass('open');
        });
    }

    function countRigs() {
        var riggCount = $('#oversiktTable').find('tbody tr:visible').length;
        $('.riggCounter').text(riggCount + ((riggCount == 1) ? ' rigg' : ' rigger'));
    }

    function convertToNumber(num) {
        var number = parseFloat( num.replace( /[$,]/g, '') );
        if(isNaN(number)) {
            return 0;
        } else {
            return number;
        }
    }

    function convertToCurrency(num) {
        return (num + "").replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1 ");
    }

    function countRigRateSum() {
        var riggSum = 0;
        $('#oversiktTable').find('tbody tr:visible .rigRate').each(function() {
            riggSum += convertToNumber($(this).text());
            $('.summaryRow .rigRate').text("$" + convertToCurrency(riggSum));
        });
    }

})(jQuery);