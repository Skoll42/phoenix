<?php
/*
 * Template Name: Marine Traffic
 */
?>
<?php get_header(); ?>
<div class="marinetraffic-page">
    <div class="container">
        <div class="post-content">
            <h1><?php the_title(); ?></h1>
        </div>
        <div class="marine-traffic">
            <script type="text/javascript">
                width = "100%";
                height = "500px";
                border = "0";
                shownames = "false";
                latitude = "60.2460";
                longitude = "4.9467";
                zoom = "9";
                maptype= "3";
                trackvessel = "0";
                fleet="";
                remember= "false";
                language = "no";
                showmenu = true;
            </script>
            <script type="text/javascript" src="http://www.marinetraffic.com/js/embed.js"></script>
        </div>
    </div>
</div>
<?php get_footer(); ?>