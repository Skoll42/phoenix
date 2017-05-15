<?php if (get_query_var('paged', 1) <= 1): ?>
    <?php if (bt_is_podcast_archive()): ?>
        <?php module_template('podcast/category'); ?>
    <?php else : ?>
        <?php module_template('theme/archive/_fronted'); ?>
        <div class="container">
            <div class="row">
                <div class="horizontal-separator"></div>
            </div>
        </div>
        <?php module_template('theme/archive/_archive'); ?>
    <?php endif; ?>
<?php else: ?>
    <?php module_template('theme/archive/_archive'); ?>
<?php endif; ?>
