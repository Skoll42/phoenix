(function($) {
    $(document).ready(function(){
        $('[id$="-all"] > ul.categorychecklist').each(function() {
            var $list = $(this);
            var $firstChecked = $list.find(':checkbox:checked').first();

            if ( !$firstChecked.length )
                return;

            var pos_first = $list.find(':checkbox').position().top;
            var pos_checked = $firstChecked.position().top;

            $list.closest('.tabs-panel').scrollTop(pos_checked - pos_first + 5);
        });
    });
})(jQuery);