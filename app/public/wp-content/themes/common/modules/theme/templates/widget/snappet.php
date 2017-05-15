<section class="snappet">
    <header class="category-background">
        <a href="<?php echo get_post_type_archive_link( 'snappet' ); ?>" target="<?php echo (in_iframe() ? '_parent' : '_blank'); ?>">SNAPPET</a>
    </header>
    <div class="snappet-body">
        <?php bt_archive_insert_the_post('snappet-0-snappet'); ?>

        <?php bt_archive_insert_the_post('snappet-1-snappet'); ?>

        <?php bt_archive_insert_the_post('snappet-2-snappet'); ?>

        <?php bt_archive_insert_the_post('snappet-3-snappet'); ?>

        <?php bt_archive_insert_the_post('snappet-4-snappet'); ?>

        <?php bt_archive_insert_the_post('snappet-5-snappet'); ?>

        <?php bt_archive_insert_the_post('snappet-6-snappet'); ?>

        <div class="clearfix"></div>
    </div>
    <footer class="category-background">
        <a href="<?php echo get_post_type_archive_link( 'snappet' ); ?>" title="Snappet" target="<?php echo (in_iframe() ? '_parent' : '_blank'); ?>">SE FLERE</a>
    </footer>
</section>