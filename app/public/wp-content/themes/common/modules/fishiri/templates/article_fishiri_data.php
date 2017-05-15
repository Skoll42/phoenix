<?php
    $article_id = $__data['article_id'];

    $mentionedCompanies = wp_get_object_terms($article_id, 'mentioned_companies');
    $rigNames = get_post_meta($article_id, 'rw_mentioned_rigs', true);
    $feltNames = get_post_meta($article_id, 'rw_mentioned_felt', true);
?>
<div class="fishiri-block">
    <?php if (count($mentionedCompanies) > 0): ?>
        <?php module_template('fishiri/mentioned-companies/widget-mentioned-companies', ['companies' => $mentionedCompanies]); ?>
    <?php endif; ?>

    <?php if (!empty($rigNames[0])): ?>
        <?php $rigsByNames = get_riggdata_by_names($rigNames);?>
        <?php module_template('fishiri/riggdata/widget-rigs', ['rigs' => $rigsByNames]); ?>
        <?php module_template('fishiri/riggdata/widget-articles', ['rigItem' => $rigsByNames[0]]); ?>
    <?php endif; ?>

    <?php if (!empty($feltNames[0])): ?>
        <?php $feltsByNames = get_feltdata_by_names($feltNames); ?>
        <?php module_template('fishiri/feltdata/widget-felt', ['felts' => $feltsByNames]); ?>
        <?php module_template('fishiri/feltdata/widget-articles', ['feltItem' => $feltsByNames[0]]); ?>
    <?php endif; ?>
</div>
