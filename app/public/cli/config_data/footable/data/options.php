<?php return array (
  'general' => 
  array (
    'type' => 'plugin',
    'active' => true,
  ),
  'options' => 
  array (
    'footable' => 
    array (
      'selector' => '.footable',
      'enable_sorting' => 'on',
      'enable_filtering' => 'on',
      'breakpoint_tablet' => '768',
      'breakpoint_phone' => '320',
      'columns_tablet' => '4',
      'columns_phone' => '2',
      'theme' => 'bootstrap',
      'custom_css' => '',
      'custom_js_before' => 'function bindFilterSelectionWithInput(filter) {
        $(filter).change(function(e) {
            e.preventDefault();
            $(\'#oversiktTable\').trigger(\'footable_filter\', {
                filter: $(\'#filter\').text()
            });
        });

        $(filter).change(function(e) {
            e.preventDefault();
            $(\'#oversiktTable\').data(\'footable-filter\').filter($(\'#filter\').text());
        });
    }

    function addSelectedFilterToQuery(filter, e) {
        var selected = $(filter).find(\':selected\').val();
        if(selected == \'Alle\') {
            selected = \'\';
        }

        if (selected && selected.length > 0) {
            e.filter += (e.filter && e.filter.length > 0) ? \' \' + selected : selected;
            e.clear = !e.filter;
        }
    }

function countRigs() {
        $(\'.riggCounter\').text($(\'#oversiktTable tbody tr[style!="display: none;"]\').length + \' rigger\');
    }

    function onFilterChanged() {
        $(\'select\').change(function() {
            countRigs();
        });

        $(\'#nameFilter\').keyup(function() {
            countRigs();
        });
    }',
      'custom_js_after' => '        $(function () {
            $(\'.footable\').footable().bind(\'footable_filtering\', function(e) {
                $(\'.summaryRow select\').each(function() {
                    addSelectedFilterToQuery(this, e);
                });
            });

            $(\'.summaryRow select\').each(function() {
                bindFilterSelectionWithInput(this);
            });
            onFilterChanged();
        });
        
',
      'scripts_in_footer' => 'on',
    ),
  ),
  'custom' => 
  array (
  ),
);