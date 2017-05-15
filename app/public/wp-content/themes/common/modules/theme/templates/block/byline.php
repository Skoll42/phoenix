<div class="byline-block">
    <div class="row">
        <div class="col-xs-12">
            <div class="byline-block-content">
                <?php if (get_post_type() == 'pressrelease') : ?>
                    <?php module_template('theme/block/byline/pressrelease'); ?>
                <?php else: ?>
                    <?php module_template('theme/block/byline/author'); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
