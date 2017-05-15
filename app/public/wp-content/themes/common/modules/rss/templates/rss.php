<?php
$feeds = [
    'aftenbladet' => null,
    'maritime' => null,
    'ilaks' => null,
    'offshore' => null,
];
$query = wprss_get_all_feed_sources();
while ($query->have_posts()) {
    $query->the_post();
    $identifier = get_field('field_57a91737845a6');

    $feed = [
        'id' => get_the_ID(),
        'title' => get_the_title(),
        'url' => rss_get_source_domain_url(),
        'posts' => [],
    ];

    $feed_items = wprss_get_feed_items_query(array(
        'feed_limit' => 5,
        'source' => $feed['id'],
    ));
    while ($feed_items->have_posts()) {
        $feed_items->the_post();
        $feed['posts'][] = [
            'title' => get_the_title(),
            'url' => rss_get_item_url(),
        ];
    }
    wp_reset_query();

    $feeds[$identifier] = $feed;
}
?>
<div class="rss-block">
    <div class="container">
        <div class="row">
            <?php foreach ($feeds as $identifier => $feed) : ?>
            <div class="col-sm-6 col-md-3 feed-source">
                <div class="rss-feed-logo">
                    <a target="_blank" title="<?php echo esc_attr($feed['title']); ?>" href="<?php echo $feed['url']; ?>" class="<?php echo $identifier; ?>">
                        <img class="img-responsive" src="<?php module_img('rss/logo-' . $identifier . '.png') ?>"/>
                    </a>
                </div>

                <ul>
                    <?php foreach ($feed['posts'] as $feed_post) : ?>
                    <li>
                        <a href="<?php echo $feed_post['url']; ?>" target="_blank"><?php echo $feed_post['title']; ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <div class="visible-xs mobile-separator"></div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</div>
