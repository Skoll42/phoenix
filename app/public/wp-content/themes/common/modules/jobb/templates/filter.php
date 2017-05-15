<?php
    get_header();
?>
    <div class="container stillinger-page">
        <div id="filter-page-carousel" class="row job-header">
            <div class="cool-block visible-xs col-xs-12 job-positions">
                <h2>PROFILERTE STILLINGER</h2>
                <div class="latest-jobs-container">
                    <div id="jobb-widget" class="jobb-widget" data-items-height="500" data-bgcolor="#fafafa"></div>
                </div>
            </div>
            <div class="col-sm-12 hidden-xs">
                <div class="job-carousel-container">
                    <h2>Profilerte stillinger</h2>
                    <div class="jobb-carousel" data-grid-items="4" data-bgcolor=""></div>
                </div>
            </div>
        </div>
        <div id="filter-page" class="row row-layout">
            <div class="col-md-9 jobb-page-container">
                <div id="jobb-page-list" class="jobb-page-list"></div>
            </div>

            <div id="right-block" class="col-md-3">
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
<?php get_footer();?>
