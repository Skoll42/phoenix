<?php
    get_header();
    $query = get_dockedships_articles();
?>
    <div class="container front-grid">
        <div class="row posts-container">
            <div class="col-xs-12">
                <div class="row">
                    <?php $counter = 0; ?>
                    <?php while(itera_have_posts($query) && $counter < 1): $query->the_post(); $counter++; ?>
                        <div class="col-xs-12 col-md-8">
                            <?php module_template('theme/article/medium'); ?>
                        </div>
                    <?php endwhile; ?>

                    <div class="col-xs-12 col-md-4">
                        <div class="row">
                            <?php $counter = 0; ?>
                            <?php while(itera_have_posts($query) && $counter < 2): $query->the_post(); $counter++; ?>
                                <div class="col-xs-12 col-sm-6 col-md-12">
                                    <?php module_template('theme/article/small'); ?>
                                </div>
                                <?php if($counter == 1): ?>
                                    <div class="ad-nexus-ad col-xs-12 visible-xs" data-id="sysla-wph-front-board-1"></div>
                                <?php endif; ?>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <?php $counter = 0; ?>
                    <?php while(itera_have_posts($query) && $counter < 6): $counter++; ?>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <?php if($counter == 4): ?>
                                <?php module_template('sponsored/block'); ?>
                            <?php else: $query->the_post(); ?>
                                <?php module_template('theme/article/small'); ?>
                            <?php endif; ?>
                        </div>
                        <?php if($counter % 2 == 0): ?><div class="clearfix visible-sm"></div><?php endif; ?>
                        <?php if($counter % 3 == 0): ?><div class="clearfix visible-md visible-lg"></div><?php endif; ?>
                    <?php endwhile; ?>

                    <div class="clearfix"></div>

                    <div class="col-xs-12 col-md-4">
                        <div class="row">
                            <?php $counter = 0; ?>
                            <?php while(itera_have_posts($query) && $counter < 2): $query->the_post(); $counter++; ?>
                                <div class="col-xs-12 col-sm-6 col-md-12">
                                    <?php module_template('theme/article/small'); ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <?php $counter = 0; ?>
                    <?php while(itera_have_posts($query) && $counter < 1): $query->the_post(); $counter++; ?>
                        <div class="col-xs-12 col-md-8">
                            <?php module_template('theme/article/medium'); ?>
                        </div>
                    <?php endwhile; ?>

                    <div class="clearfix"></div>

                    <?php $counter = 0; ?>
                    <?php while(itera_have_posts($query) && $counter < 6): $counter++; ?>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <?php if($counter == 6): ?>
                                <?php module_template('sponsored/block', array('block_id' => 'internal')); ?>
                            <?php else: $query->the_post(); ?>
                                <?php module_template('theme/article/small'); ?>
                            <?php endif; ?>
                        </div>
                        <?php if($counter % 2 == 0): ?><div class="clearfix visible-sm"></div><?php endif; ?>
                        <?php if($counter % 3 == 0): ?><div class="clearfix visible-md visible-lg"></div><?php endif; ?>
                    <?php endwhile; ?>

                    <div class="ad-nexus-ad col-xs-12 visible-xs" data-id="sysla-wph-front-board-2"></div>
                    <div class="ad-nexus-ad col-md-8 visible-md visible-lg" data-id="sysla-wde-front-netboard-1"></div>
                    <div class="ad-nexus-ad col-sm-12 visible-sm" data-id="sysla-wtb-front-netboard-1"></div>
                    <div class="ad-nexus-ad nexus-skyscrapper" data-id="sysla-wde-front-skyscraperright-1"></div>

                    <div class="col-xs-12 col-md-4">
                        <div class="row">
                            <?php $counter = 0; ?>
                            <?php while(itera_have_posts($query) && $counter < 2): $query->the_post(); $counter++; ?>
                                <div class="col-xs-12 col-sm-6 col-md-12">
                                    <?php module_template('theme/article/small'); ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <?php $counter = 0; ?>
                    <?php while(itera_have_posts($query) && $counter < 12): $query->the_post(); $counter++; ?>
                        <div class="col-xs-12 col-sm-6 col-md-4">
                            <?php module_template('theme/article/small'); ?>
                        </div>
                        <?php if($counter % 2 == 0): ?><div class="clearfix visible-sm"></div><?php endif; ?>
                        <?php if($counter % 3 == 0): ?><div class="clearfix visible-md visible-lg"></div><?php endif; ?>
                    <?php endwhile; ?>

                    <div class="ad-nexus-ad col-xs-12 visible-xs" data-id="sysla-wph-front-board-3"></div>
                    <div class="ad-nexus-ad col-md-8 visible-md visible-lg" data-id="sysla-wde-front-netboard-2"></div>
                    <div class="ad-nexus-ad col-sm-12 visible-sm" data-id="sysla-wtb-front-netboard-2"></div>

                    <div class="col-xs-12 col-md-4">
                        <div class="row">
                            <?php $counter = 0; ?>
                            <?php while(itera_have_posts($query) && $counter < 2): $query->the_post(); $counter++; ?>
                                <div class="col-xs-12 col-sm-6 col-md-12">
                                    <?php module_template('theme/article/small'); ?>
                                </div>
                            <?php endwhile; ?>
                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
<?php if(itera_have_posts($query)) : ?>
    <?php module_template('theme/archive/_archive'); ?>
<?php endif;?>
<?php get_footer(); ?>