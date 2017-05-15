(function ($){
    var frontendDockedShipsManager;
    
    $( document ).ready(function() {
        frontendDockedShipsManager = new DockedShipsManager();
        init();
        bindFilterChange();
        bindClearFilters();
        bindSearch();
    });

    function init() {
        frontendDockedShipsManager.getDockedShipsFilters($.Deferred(), drawFilters);
    }

    function drawData(response) {
        var dateString = response['lastUpdated'];
        var lastUpdated = new Date(dateString.replace(' ', 'T').substring(0, dateString.length-5));
        $('.edit-date .date-month').html(lastUpdated.getDate() + ('0' + (lastUpdated.getMonth()+1)).slice(-2));
        $('.edit-date .year').html(lastUpdated.getFullYear());
        $('.total-docked .value').html(response['dockedShips']['total_count']);
        $('.category-docked .categories').html(formatCategoriesHtml(response['shipTypesAmount']));
        drawShips(response['dockedShips']['items'], hideLoading);
    }

    function drawFilters(filters) {
        $('#ship-filter').html(getOwners(filters['owners']));
        $('#status-filter').html(getStatuses(filters['statuses']));
        $('#type-filter').html(getTypes(filters['types']));

        frontendDockedShipsManager.getDockedShipsByParams($.Deferred(), getQuery());
    }

    function getTypes(types) {
        var html = '<option value="Alle">Filter på rederi</option>';
        for(var i = 0; i < types.length; i++) {
            var type = types[i];
            html += '<option value="' + type + '">' + (type ? type : "Andre") + '</option>'
        }
        return html;
    }

    function getOwners(owners) {
        var html = '<option value="Alle">Filter på rederi</option>';
        for(var i = 0; i < owners.length; i++) {
            var owner = owners[i];
            html += '<option value="' + owner.id + '">' + (owner.hasOwnProperty('name') ? owner.name : "Andre") + '</option>'
        }
        return html;
    }

    function getStatuses(statuses) {
        var html = '<option value="Alle">Filter på status</option>';
        for(var i = 0; i < statuses.length; i++) {
            var status = statuses[i];
            html += '<option value="' + status + '"' + (status == "I opplag" ? " selected" : "") + '>' + (status ? status : "Andre") + '</option>'
        }
        return html;
    }

    function drawShips(items, callback) {
        $('#ship-items').html(formShipsHtml(items));
        callback();
    }

    function formShipsHtml(items) {
        return items.length == 0 ? '<h4 class="col-xs-12">No results found</h4>' : getShipsHtml(items);
    }

    function getShipsHtml(items) {
        var html = '';
        while(items.length) {
            var pair = items.slice(0,2);
            html += '<div class="cut-item">';
            for(var i = 0; i < pair.length; i++) {
                html += formatItem(pair[i]);
                items.shift();
            }
            html += '</div>';
        }
        return html;
    }

    function formatCategoriesHtml(types) {
        var html = '';
        for (var typeSkip in types) {
            html += '<li>' + (typeSkip ? typeSkip : 'Andre') + ':<span class="value">' + types[typeSkip] + '</span></li>';
        }
        return html ? html : '<h4>No results found</h4>';
    }

    function formatItem(item) {
        return '<div class="col-xs-12 col-sm-6 item"><div class="company">' + (item.owner ? item.owner.name : 'Unknown') + '</div>' +
            (item.media != null ? '<div class="bg-image embed-responsive embed-responsive-16by9"><img src="' + item.media.s3_url + '"/>' +
            (item.date_in ? '<div class="indicator">' + getIndicator(item.date_in) + '</div>' : '') + '</div>' : '') +
            '<ul class="info">' + (item.name ? '<li>Navn på skip: <span class="ship-name">' + item.name + (item.type_skip ? ' (' + item.type_skip + ')' : '') + '</span></li>' : '') +
            (item.flagg ? '<li>Flagg: <span class="country">' + item.flagg + '</span></li>' : '') +
            (item.status ? '<li>Status: <span class="country">' + item.status + '</span></li>' : '') +
            (item.location_name ? '<li>Ligger i opplag: <span class="location">' + item.location_name +
            (item.date_in ? ' (per ' + formatLocationDate(item.date_in) + ')' : '') + '</span></li>' : '') +
            (item.articles.length ? '<li>I nyhetene: ' + formatNewsLinks(item.articles) + '<div><a class="alle-link" href="ship/' + getShipSlug(item.name) + '">Se alle artikler</a></div></li>' : '') + '</ul></div>';
    }

    function formatNewsLinks(news) {
        var links = [];
        var newsCount = news.length;
        for (var i = 0; i < newsCount; i++) {
            var article = news[i];
            links.push('<a href="' + article.link + '">' + article.title + '</a>');
        }

        return links.join(', ');
    }

    function getIndicator(date) {
        var dateIn = new Date(date);
        var now = new Date();
        var timeDiff = Math.abs(now.getTime() - dateIn.getTime());
        var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
        return diffDays <= 10 ? getNewIndicator() : '';
    }

    function getNewIndicator() {
        return '<span class="new">NY</span>';
    }

    function getShipSlug(name) {
        return name.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
    }

    function formatLocationDate(date) {
        var monthNames = ["januar", "februar", "mars", "april", "mai", "juni",
            "juli", "august", "september", "oktober", "november", "desember"];
        date = date.split("-");
        return date[2].split("T")[0] + '. ' + monthNames[parseInt(date[1], 10) - 1] + ' ' + date[0];
    }

    function bindFilterChange() {
        $('#ship-filter, #type-filter, #status-filter').change(function() {
            showLoading();
            frontendDockedShipsManager.getDockedShipsByParams($.Deferred(), getQuery());
        });
    }

    function bindSearch() {
        $('#search-form').submit(function(e) {
            showLoading();
            e.preventDefault();
            frontendDockedShipsManager.getDockedShipsByParams($.Deferred(), getQuery());
        });
    }

    function getQuery() {
        return {
            ownerId: getFilterSelection(),
            status: getStatusSelection(),
            typeSkip: getTypeSelection(),
            search: getSearchInput(),
            callback: drawData
        };
    }

    function bindClearFilters() {
        $('#clear-filters').click(function(){
            showLoading();
            $('#type-filter').val('Alle');
            $('#ship-filter').val('Alle');
            $('#status-filter').val('Alle');
            $('input#search').val('');
            frontendDockedShipsManager.getDockedShipsByParams($.Deferred(), getQuery());
        });
    }


    function getStatusSelection() {
        return $('#status-filter').find('option:selected').val();
    }

    function getTypeSelection() {
        return $('#type-filter').find('option:selected').val();
    }

    function getFilterSelection() {
        return $('#ship-filter').find('option:selected').val();
    }

    function getSearchInput() {
        return $('input#search').val();
    }

    function hideLoading () {
        var itemsContainer = $('#ship-items');
        $('.item', itemsContainer).removeClass('hidden');
        itemsContainer.removeClass('loading');
    }

    function showLoading () {
        var itemsContainer = $('#ship-items');
        $('.item', itemsContainer).addClass('hidden');
        itemsContainer.addClass('loading');
    }
})(jQuery);