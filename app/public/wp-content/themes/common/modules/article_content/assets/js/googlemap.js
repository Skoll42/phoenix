(function($) {

    function render_map( container ) {
        var args = {
            zoom        : 15,
            scrollwheel: false,
            mapTypeId   : google.maps.MapTypeId.ROADMAP,
            styles: [
                {"featureType":"water","elementType":"geometry","stylers":[{"color":"#e9e9e9"},{"lightness":17}]},
                {"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":20}]},
                {"featureType":"road.highway","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"lightness":17}]},
                {"featureType":"road.highway","elementType":"geometry.stroke","stylers":[{"color":"#ffffff"},{"lightness":29},{"weight":0.2}]},
                {"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":18}]},
                {"featureType":"road.local","elementType":"geometry","stylers":[{"color":"#ffffff"},{"lightness":16}]},
                {"featureType":"poi","elementType":"geometry","stylers":[{"color":"#f5f5f5"},{"lightness":21}]},
                {"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#dedede"},{"lightness":21}]},
                {"elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#ffffff"},{"lightness":16}]},
                {"elementType":"labels.text.fill","stylers":[{"saturation":36},{"color":"#333333"},{"lightness":40}]},
                {"elementType":"labels.icon","stylers":[{"visibility":"off"}]},
                {"featureType":"transit","elementType":"geometry","stylers":[{"color":"#f2f2f2"},{"lightness":19}]},
                {"featureType":"administrative","elementType":"geometry.fill","stylers":[{"color":"#fefefe"},{"lightness":20}]},
                {"featureType":"administrative","elementType":"geometry.stroke","stylers":[{"color":"#fefefe"},{"lightness":17},{"weight":1.2}]}
            ]
        };

        return new google.maps.Map( container.find('.map')[0], args);
    }

    function enableScrollwheel(map) {
        if(map) map.setOptions({ scrollwheel: true });
    }

    function disableScrollwheel(map) {
        if(map) map.setOptions({ scrollwheel: false });
    }

    function set_markers( map, container ) {
        var markers = container.find('.marker');

        markers.each(function(){
            var $marker = $(this);

            var marker = new google.maps.Marker({
                position    : new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') ),
                map         : map,
                optimized   : false,
                icon        : {
                    anchor: new google.maps.Point(16, 16),
                    size: new google.maps.Size(69.1, 101.9),  // original size you defined in the SVG file
                    scaledSize: new google.maps.Size(32, 32), // desired display size
                    url: 'data:image/svg+xml;charset=utf-8,' + encodeURIComponent('\
                        <svg height="32" width="32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"\
                            viewBox="0 0 69.1 101.9" style="enable-background:new 0 0 69.1 101.9;" xml:space="preserve">\
                            <path fill="' + googlemap.marker_color + '" d="M34.5,0.8C15.8,0.8,0.6,16,0.6,34.7c0,0.4,0,0.8,0,1.2c0.1,3.6,0.8,7,1.9,10.2c7.3,23.7,32,54.7,32,54.7s24.7-31,31.9-54.7\
                            c1.1-3.2,1.8-6.6,1.9-10.2c0-0.4,0-0.8,0-1.2C68.4,16,53.2,0.8,34.5,0.8z"/>\
                            <circle fill="#FFFFFF" cx="34.5" cy="34.7" r="16.6"/>\
                        </svg>')
                }
            });

            if( $marker.html() ) {
                var infowindow = new google.maps.InfoWindow({
                    content : $marker.html()
                });

                google.maps.event.addListener(marker, 'click', function() {
                    infowindow.open( map, marker );
                });
            }
        });

        return markers;
    }

    function center_map(map, markers) {
        var bounds = new google.maps.LatLngBounds();

        markers.each(function(){
            var $marker = $(this);
            var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
            bounds.extend( latlng );
        });

        if( markers.length == 1 ) {
            map.setCenter(bounds.getCenter());
            map.setZoom(16);
        } else {
            map.fitBounds( bounds );
        }
    }

    function initMap() {
        var container = $('.article-content-map:first');
        if (!container.length) return;

        var map = render_map(container);
        var markers = set_markers(map, container);
        center_map(map, markers);

        var clicks = 0;
        container.click(function() {
            if (clicks % 2 === 0) {
                enableScrollwheel(map);
            }
            else {
                disableScrollwheel(map);
            }
            clicks++;
        });
    }

    window['initMap'] = initMap;

    (function loadMapAPI() {
        if (!googlemap.api_key) return;
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = 'https://maps.googleapis.com/maps/api/js?key=' + googlemap.api_key + '&callback=initMap';
        document.body.appendChild(script);
    })();

})(jQuery);
