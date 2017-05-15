var $FOOTABLE = $FOOTABLE || {};
(function( $FOOTABLE, $, undefined ) {

    jQuery.fn.attrAppendWithComma=function(a,b){var c;return this.each(function(){c=$(this),void 0!==c.attr(a)&&""!=c.attr(a)?c.attr(a,c.attr(a)+","+b):c.attr(a,b)})};jQuery.fn.footableAttr=function(a,b){return this.each(function(){var c=$(this);c.data("auto-columns")!==!1&&(c.find("thead th:gt("+a+")").attrAppendWithComma("data-hide","tablet"),c.find("thead th:gt("+b+")").attrAppendWithComma("data-hide","phone"))})},jQuery.fn.footableFilter=function(a){return this.each(function(){var b=$(this);b.data("filter")||b.data("filter")===!1||b.data("filter-text-only","true").before('<div class="footable-filter-container"><input placeholder="'+a+'" style="float:right" type="text" class="footable-filter" /></div>')})},jQuery.fn.footablePager=function(){return this.each(function(){var a=$(this);if(a.data("page")!==!1){var b=$('<tfoot class="hide-if-no-paging"><tr><td><div class="pagination pagination-centered"></div></td></tr></tfoot>');b.find("td").attr("colspan",a.find("thead th").length),a.find("tbody:last").after(b)}})};

    $FOOTABLE.init = function() {

        function onFilterChanged() {
            $('select').change(function() {
                if(checkLocation('/feltdata/')) {
                    countFelts();
                } else if(checkLocation('/rigg/')) {
                    countRigs();
                }
            });

            $('#nameFilter').keyup(function() {
                if(checkLocation('/feltdata/')) {
                    countFelts();
                } else if(checkLocation('/rigg/')) {
                    countRigs();
                }
            });
        }

        function checkLocation(location) {
            return window.location.href.indexOf(location) > -1;
        }

        function bindFilterSelectionWithInput(filter) {
            $(filter).change(function (e) {
                e.preventDefault();
                $('#oversiktTable').trigger('footable_filter', {
                    filter: $('#nameFilter').text()
                });
            });
        }

        function addSelectedFilterToQuery(filter, e) {
            var selected = $(filter).find(':selected').val();
            if(selected == 'Alle') {
                selected = '';
            }

            if (selected && selected.length > 0) {
                e.filter += (e.filter && e.filter.length > 0) ? ' ' + selected : selected;
                e.clear = !e.filter;
            }
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

        function countFelts() {
            var feltCount = $('#oversiktTable').find('tbody tr:visible').length;
            $('.feltCounter').text(feltCount + ' felt');
        }

        function getFilter(selector) {
            var filterString = $(selector).val();
            filterString = filterString == 'Alle' ? '' : filterString;
            var filterColumnClass = $(selector.split(' ')[0]).data('filter-columns');

            return {filter: filterString, filterColumn: filterColumnClass};
        }

        function getSelectedFilters() {
            return {
                name: getFilter('#nameFilter'),
                status: getFilter('#operatorFilter option:selected'),
                owner: getFilter('#statusFilter option:selected'),
                operator: getFilter('#locationFilter option:selected')
            };
        }

        function hasFilter(column, filter) {
            return column.text().toUpperCase().indexOf(filter.toUpperCase()) >= 0;
        }

        $(function () {
            $('.footable').footableAttr(3,1).footableFilter("search").footable({ breakpoints: { phone:480, portrait:768, landscape:992, tablet:1024 }, filter: {
                filterFunction: function(index){
                    var $td = $(this).find('td'),
                        filters = getSelectedFilters();

                    for(var key in filters){
                        if(filters.hasOwnProperty(key)) {
                            var filterObj = filters[key];
                            if (filterObj.filter != '' && !hasFilter($td.filter(filterObj.filterColumn), filterObj.filter)) {
                                return false;
                            }
                        }
                    }
                    return true;
                }
            }
            }).bind({
                'footable_filtering' : function(e) {
                    $('.summaryRow select').each(function() {
                        addSelectedFilterToQuery(this, e);
                    });
                },

                'footable_filtered' : function(e) {
                    countFelts();
                    countFeltInvestSum();
                }
            });
            $('.summaryRow select').each(function() {
                bindFilterSelectionWithInput(this);
            });

            onFilterChanged();

        });
    };
}( $FOOTABLE, jQuery ));

jQuery(function($) {
    $FOOTABLE.init();
});
