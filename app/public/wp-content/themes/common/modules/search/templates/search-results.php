<?php
$isMobile = !empty($__data['mobile']) && $__data['mobile'];
?>
<div class="search-results<?php echo $isMobile ? '-mobile' : ''; ?> hidden">
    <div class="search-title">Resultat</div>
    <div class="result-list row"></div>
    <div class="see-all hidden"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">SE OG FILTRÉR RESULTATER <span class="see-all-icon"><?php insert_svg('header/all-search-results-icon.svg'); ?></span></a></div>
    <div class="loader hidden"><img src="<?php module_img('pagination/loader.svg'); ?>" /></div>
</div>