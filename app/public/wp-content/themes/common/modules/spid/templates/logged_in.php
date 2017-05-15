<?php
$bounce_page = isset($_GET['spid_page']) && $_GET['spid_page'] ? $_GET['spid_page'] : null;
?>
<?php get_header(); ?>

<div class="spid-logged-in">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 text-center">
                <?php if ($bounce_page): ?>
                    <h2>DU BLIR NÅ SENDT TILBAKE TIL SYSLA</h2>
                <?php else: ?>
                    <h2>DU ER NÅ LOGGET INN OG VIL<br/>BLI SENDT TIL ARTIKKELEN</h2>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="sites-information">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="logos">
                        <div class="sysla">
                            <div class="logo-wrapper">
                                <span class="site-logo sysla-small">
                                    <?php insert_svg(bt_header_get_section_logo('sysla')); ?>
                                </span>
                            </div>
                        </div>
                        <div class="syslagronn">
                            <div class="logo-wrapper">
                                <span class="site-logo sysla-small">
                                    <?php insert_svg(bt_header_get_section_logo('sysla')); ?>
                                </span>
                                    <div class="logo-divider"></div>
                                <span class="site-logo logo-small gronn-small">
                                    <?php insert_svg(bt_header_get_section_logo('gronn')); ?>
                                </span>
                            </div>
                        </div>
                        <div class="offshore">
                            <div class="logo-wrapper">
                                <span class="site-logo sysla-small">
                                    <?php insert_svg(bt_header_get_section_logo('sysla')); ?>
                                </span>
                                    <div class="logo-divider"></div>
                                <span class="site-logo logo-small offshore-small">
                                    <?php insert_svg(bt_header_get_section_logo('offshore')); ?>
                                </span>
                            </div>
                        </div>
                        <div class="maritim">
                            <div class="logo-wrapper">
                                <span class="site-logo sysla-small">
                                    <?php insert_svg(bt_header_get_section_logo('sysla')); ?>
                                </span>
                                    <div class="logo-divider"></div>
                                <span class="site-logo logo-small maritim-small">
                                    <?php insert_svg(bt_header_get_section_logo('maritim')); ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>