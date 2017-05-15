<div class="snappet-category-list">
    <div class="container">
        <div class="snappet-title">
            <div class="arrow"></div>
            <h3>SNAPPET</h3>
        </div>
        <div class="row posts-container-regular">
            <?php $counter = 0; ?>
            <?php while(itera_have_posts()): the_post(); $counter++; ?>
                <div class="col-xs-12">
                    <?php module_template('theme/article/snappet'); ?>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?php module_template('pagination/pagination', ['posts_container_selector' => '.posts-container-regular']); ?>
            </div>
        </div>
    </div>
</div>
