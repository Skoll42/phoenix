<?php
$companies = get_the_terms( get_the_ID(), 'sponsored_company');
if( !empty($companies) ) {
    $company = array_pop($companies);
    if ($company->slug == 'annonse') {
        $company_logo_url = get_field('e24_company_logo_url');
    } else {
        $custom_field = get_field('sponsored_header_image', $company);
        $company_logo_url = $custom_field['url'];
    }
}
?>
<div class="e24-header">
    <span class="image-aligner"></span>
    <?php if (!empty($company_logo_url)) : ?>
        <img src="<?php echo $company_logo_url; ?>">
    <?php endif; ?>
    <div class="e24-title">Annonseinnhold</div>
</div>