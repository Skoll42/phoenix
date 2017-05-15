function bt_lazy_load_image( img ) {
    var $img = jQuery( img ),
        src = $img.attr( 'data-lazy-src' );

    if ( ! src || 'undefined' === typeof( src ) )
        return;

    $img.unbind( 'scrollin' ) // remove event binding
        .hide()
        .removeAttr( 'data-lazy-src' )
        .attr( 'data-lazy-loaded', 'true' );

    img.src = src;
    $img.fadeIn();
}
