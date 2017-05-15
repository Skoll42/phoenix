<div class="mobile-menu">
	<div class="search-area-mobile hidden">
        <input type="text" class="search-input category-border" value="">
        <input type="submit" class="search-button" value="">
		<input type="submit" class="close-search-button hidden" value="">
    </div>
	<div class="search-container-mobile hidden">
		<?php module_template('search/keywords', ['mobile' => true]); ?>
		<?php module_template('search/search-results', ['mobile' => true]); ?>
	</div>
	<div class="section-links-mobile">
		<?php wp_nav_menu([
			'walker' => new BT_Walker_Nav_Menu(),
			'container' => false,
			'menu_class' => '',
			'menu' => 'header-menu',
		]); ?>
	    <div class="clearfix"></div>
	</div>
	<div class="shipdata-links">
		<?php wp_nav_menu([
			'container' => false,
			'menu_class' => '',
			'menu' => 'fishiri-menu'
		]); ?>
	</div>
	<div class="bottom-block">
	    <div class="menu-info">
	        Sysla.no arbeider etter<br>
	        Vær Varsom-plakatens regler for<br>
	        god presseskikk.
	    </div>
	</div>
</div>