function DockedShipsManager() {}

(function ($){

    // Actions

    DockedShipsManager.prototype.getDockedShipsByParams = function(dfd, params) {
        $.ajax({
            url: ajaxurl,
            type: 'GET',
            data: {
                action: 'get_docked_ships',
                noPaging: 'true',
                search: {
                    search: params['search'],
                    status: params['status'] != 'Alle' ? params['status'] : '',
                    typeSkip: params['typeSkip'] != 'Alle' ? params['typeSkip'] : '',
                    ownerId: params['ownerId'] != 'Alle' ? params['ownerId'] : ''
                },
                sortby: params['sortby'] ? params['sortby'] : 'name',
                sortdir: params['sortdir'] ? params['sortdir'] : ''
            },
            dataType: 'json',
            success: function(response) {
                if(params['callback'] && response.success) {
                    dfd.resolve(params['callback'](response.data));
                    $('body').trigger('dockedships.loaded');
                }
            }
        });
        return dfd.promise();
    };

    DockedShipsManager.prototype.getDockedShipsFilters = function(dfd, callback) {
        $.ajax({
            url: ajaxurl,
            type: 'GET',
            data: {
                action: 'get_docked_ships_filters'
            },
            dataType: 'json',
            success: function(response) {
                if(callback && response.success) {
                    dfd.resolve(callback(response.data));
                }
            }
        });
        return dfd.promise();
    };
})(jQuery);