<?php
$terms = get_the_terms(get_the_ID(), 'sponsored_company');
$company = !empty($terms[0]) ? $terms[0] : null;
$sponsored_tail = !empty($company) ? get_field('sponsored_company_article_tail', $company) : null;
?>
<?php if (!empty($sponsored_tail)): ?>
    <div class="sponsored-tail"><?php echo $sponsored_tail; ?></div>
<?php endif; ?>