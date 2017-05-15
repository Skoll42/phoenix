<?php

add_theme_support( 'post-thumbnails' );
add_image_size( 'bt-small', 384, 216, true );
add_image_size( 'bt-medium', 768, 432, true );
add_image_size( 'bt-large', 1280, 720, true );

add_image_size( 'bt-portrait-medium',  580,  680, true );

add_image_size( 'bt-avatar', 50, 50, true );

add_theme_support( 'custom-header', array(
    'uploads'       => true,
    'header-text'   => false,
) );
