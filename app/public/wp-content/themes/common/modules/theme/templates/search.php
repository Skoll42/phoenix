<?php
global $wp_query;

function bt_search_is_site_checked($site) {
    return in_array($site, (array)$_GET['site']);
}

?>
<?php get_header(); ?>

<div class="result-container page-content-top page-content">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="underlined-title pages-count">
                    <h5><span><?php echo $wp_query->found_posts; ?></span> søkeresultater</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="search-area page-content">
    <div class="container">
        <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <div class="row search-input">
                <div class="col-xs-12">
                    <label>
                        <span class="screen-reader-text"><?php echo _x( 'Search for:', 'label' ); ?></span>
                        <input type="search" class="search-field" placeholder="SØKE SYSLA"
                               value="<?php echo get_search_query(); ?>" name="s" />
                    </label>
                    <input type="submit" class="search-submit" value="SØK" />
                </div>
            </div>
            <div class="row search-filters">
                <div class="col-xs-12">
                    <div id="expand-filter" class="collapse">
                        <div class="filter-title">Nettsteder</div>
                        <ul class="filter-list">
                            <li>
                                <label>
                                    <input type="checkbox" name="site[]" value="sysla" <?php echo bt_search_is_site_checked('sysla') ? 'checked' : ''; ?>/> Sysla
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" name="site[]" value="gronn" <?php echo bt_search_is_site_checked('gronn') ? 'checked' : ''; ?> /> Sysla Grønn
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" name="site[]" value="offshore" <?php echo bt_search_is_site_checked('offshore') ? 'checked' : ''; ?> /> Sysla Offshore
                                </label>
                            </li>
                            <li>
                                <label>
                                    <input type="checkbox" name="site[]" value="maritim" <?php echo bt_search_is_site_checked('maritim') ? 'checked' : ''; ?> /> Sysla Maritim
                                </label>
                            </li>
                        </ul>
                    </div>
                    <div class="clearfix"></div>
                    <a href="#expand-filter" class="expand-button" data-toggle="collapse">DETALJERT SØK</a>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="search-result page-content">
    <div class="container">
        <div class="row posts-container">
            <?php if(have_posts()) : ?>
                <?php $counter = 0; ?>
                <?php while(have_posts()): the_post(); $counter++; ?>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <?php module_template('theme/article/small'); ?>
                    </div>
                    <div class="mobile-separator"></div>

                    <?php if ($counter%2==0): ?><div class="clearfix visible-sm"></div><?php endif; ?>
                    <?php if ($counter%3==0): ?><div class="clearfix visible-md visible-lg"></div><?php endif; ?>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="no-results col-xs-12">Ingen resultater, prøv et nytt søk.</div>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <?php module_template('pagination/pagination', ['posts_container_selector' => '.posts-container']); ?>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>