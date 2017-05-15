<?php
get_header();
?>
<div class="mobile-padding-fix"></div>
<div class="container opplagsregister">
    <div class="article-content">
        <div class="row">
            <div class="col-md-8 post">
                <h1>
                    <?php the_field('dockedships_title', 'option'); ?>
                </h1>
                <h4><?php the_field('dockedships_excerpt', 'option'); ?></h4>
                <div class="post-thumbnail">
                    <?php echo get_ship_data_map(); ?>
                </div>
                <div class="excerpt"><?php the_field('dockedships_header_text', 'option'); ?></div>
                <div id="component-body">
                    <div class="overall-info">
                        <div class="cut">
                            <div class="col-xs-6 col-sm-4 section section-date">
                                <div class="edit-date">
                                    <h3>Oppdatert</h3>
                                    <div class="date-month">
                                    </div>
                                    <div class="year">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-5 col-md-4 section">
                                <div class="category-docked">
                                    <h3>Opplagsstatus</h3>
                                    <ul class="categories"></ul>
                                </div>
                            </div>
                            <div class="col-xs-6 col-sm-3 col-md-4 section">
                                <div class="total-docked">
                                    <h3>Totalt:</h3>
                                    <div class="value"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ship-grid">
                        <div class="filter">
                            <div id="clear-filters"><span>Vis alle</span></div>
                            <div class="filters">
                                <select id="ship-filter" class="form-control"></select>
                                <select id="status-filter" class="form-control"></select>
                                <select id="type-filter" class="form-control"></select>
                            </div>

                            <form id="search-form" class="search-block">
                                <input id="search" placeholder="Søk" />
                                <button class="pull-right"></button>
                            </form>
                        </div>
                        <div class="clearfix"></div>
                        <div id="ship-items" class="row loading"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="sidebar">
                    <div class="sticky-wrapper">
                        <div class="adv-block">
                            <div class="ad-nexus-ad visible-md visible-lg" data-id="<?php echo (get_current_frontpage() . '-wde-article-skyscraperright-1'); ?>"></div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="sticky-wrapper">
                        <?php module_template('oceanhub/widget'); ?>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12">
                <div class="adv-block">
                    <div class="ad-nexus-ad visible-md visible-lg" data-id="<?php echo (get_current_frontpage() . '-wde-article-netboard-1'); ?>"></div>
                    <div class="ad-nexus-ad visible-sm" data-id="<?php echo (get_current_frontpage() . '-wtb-article-netboard-1'); ?>"></div>
                    <div class="ad-nexus-ad visible-xs" data-id="<?php echo (get_current_frontpage() . '-wph-article-board-1'); ?>"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>