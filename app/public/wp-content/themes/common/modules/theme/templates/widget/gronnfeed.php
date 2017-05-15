<?php 
    include_once( ABSPATH . WPINC . '/feed.php' );
    $rss = fetch_feed( 'http://energiogklima.no/feed/' );
    $maxitems = 0;
    
    if ( ! is_wp_error( $rss ) ) {
        $maxitems = $rss->get_item_quantity( 4 );
        $rss_items = $rss->get_items( 0, $maxitems );
    }
?>
<div class="section-common gronnfeed-widget">
	<h3 class="category-background">Nyhetsfeed</h3>
	<div class="partner-company">
		<a href="http://energiogklima.no/" target="<?php echo (in_iframe() ? '_parent' : '_blank'); ?>"><img src="<?php module_img('theme/energi-klima.png'); ?>" alt="Energi Klima logo"></a>
	</div>
	<div class="down-arrow category-border-top"></div>
	<ol>
		<?php if ( $maxitems == 0 ) : ?>
            <li><?php _e( 'Ingen artikler' ); ?></li>
        <?php else : ?>
            <?php foreach ( $rss_items as $item ) : ?>
                <li>
                    <a href="<?php echo esc_url( $item->get_permalink() ); ?>"
                        title="<?php printf( __( 'Posted %s', 'my-text-domain' ), $item->get_date('j F Y | g:i a') ); ?>" target="<?php echo (in_iframe() ? '_parent' : '_blank'); ?>">
                        <div class="title"><?php echo esc_html( $item->get_title() ); ?></div>
                    </a>
                </li>
            <?php endforeach; ?>
        <?php endif; ?>
	</ol>
</div>