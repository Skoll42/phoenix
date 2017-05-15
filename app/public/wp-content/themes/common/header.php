<!DOCTYPE html>
<html lang="no" dir="ltr">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php wp_title('&ndash;', true, 'right'); ?></title>
    <link rel="profile" href="http://gmpg.org/xfn/11"/>
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>

    <?php wp_head(); ?>
</head>
<body <?php body_class('bt-body'); ?>>
	<?php $current_category = bt_archive_get_current_category()->slug; ?>
	<?php
	 	switch ($current_category) {
	 		case 'offshore':
	      		$ad_prefix = $current_category;
	      		break;
	    	case 'maritim':
	      		$ad_prefix = 'maritime';
	      		break;
	    	case 'gronn':
	      		$ad_prefix = 'syslagronn';
	      		break;
	    	default:
	      		$ad_prefix = 'sysla';
	  	}
	?>
	<?php if(!in_iframe()) : ?>
		<?php if (is_single()) : ?>
			<?php if (get_post_type() !== 'sponsored') : ?>
				<div class="hidden-xs hidden-sm">
					<div class="nexus-top-wrapper">
						<div class="container">
							<div class="ad-nexus-ad" data-id="<?php echo $ad_prefix; ?>-wde-article-topboard"></div>
						</div>
					</div>
				</div>
				<div class="visible-sm">
					<div class="nexus-top-wrapper">
						<div class="container">
							<div class="ad-nexus-ad" data-id="<?php echo $ad_prefix; ?>-wtb-article-topboard"></div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		<?php else : ?>
			<div class="hidden-xs hidden-sm">
				<div class="nexus-top-wrapper">
					<div class="container">
						<div class="ad-nexus-ad" data-id="<?php echo $ad_prefix; ?>-wde-front-topboard"></div>
					</div>
				</div>
			</div>
			<div class="visible-sm">
				<div class="nexus-top-wrapper">
					<div class="container">
						<div class="ad-nexus-ad" data-id="<?php echo $ad_prefix; ?>-wtb-front-topboard"></div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	
		<?php module_template('header/header'); ?>
	<?php endif; ?>
