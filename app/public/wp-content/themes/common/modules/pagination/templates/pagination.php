<?php if(!in_iframe()) : ?>
    <script>
    window.globalContentSelector = '<?php echo $__data['posts_container_selector']; ?>';
    </script>

    <div class="load-more">
        <div class="loader"><img src="<?php module_img('pagination/loader.svg'); ?>" /></div>
        <a href="#" class="load-more-button category-color category-border">SE MER</a>
        <div class="navigation"><?php posts_nav_link(); ?></div>
    </div>
<?php else : ?>
    <div class="bottom-padding"></div>
<?php endif; ?>
