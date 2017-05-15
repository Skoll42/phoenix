(function($) {

    function change_value_factbox_shortcode() {
        var field = $("input[name*='" + factbox_script.input_field_data_key + "']");

        if (field.length > 1) {
            var last_index = field.length - 1;
            var value = $(field[last_index - 1]).val();
            var current_value = parseInt(value.match(/(\d+)/)[1]) + 1;

            $(field[last_index]).val('[factbox id=' + current_value + ']');
        }
    }

    function add_properties_factbox() {
        var field = $("input[name*='" + factbox_script.input_field_data_key + "']");

        if(field.length > 0){
            field.prop('readonly', true);

            field.on("click", function () {
                $(this).select();
            });
        }
    }

    $(document).ready(function(){
        $('#' + factbox_script.factbox_id).find("a[data-event='add-row']").click(function(){
            change_value_factbox_shortcode();
            add_properties_factbox();
        });
        add_properties_factbox();
    });

})(jQuery);