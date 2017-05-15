<div class="container">
    <div class="row posts-container posts-container-regular">
        <?php $counter = 0; ?>
        <?php while(itera_have_posts()): the_post(); $counter++; ?>
            <div class="col-sm-6 col-md-4">
                <?php module_template('theme/article/small'); ?>
            </div>
            <?php if($counter % 2 == 0): ?><div class="clearfix visible-sm"></div><?php endif; ?>
            <?php if($counter % 3 == 0): ?><div class="clearfix visible-md visible-lg"></div><?php endif; ?>
        <?php endwhile; ?>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?php module_template('pagination/pagination', ['posts_container_selector' => '.posts-container-regular']); ?>
        </div>
    </div>
</div>
