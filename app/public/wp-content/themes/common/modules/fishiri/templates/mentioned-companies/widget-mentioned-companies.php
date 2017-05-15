<?php
    $mentioned_companies = $__data['companies'];
?>
<div class="mentioned-companies-block">
    <div class="title">Selskaper omtalt i saken</div>
    <ul class="category-color">
        <?php foreach ($mentioned_companies as $company) : ?>
            <li><span><?php echo $company->name; ?> <a href="<?php echo get_term_link($company); ?>" class="category-color">(Se Mer)</a></span></li>
        <?php endforeach; ?>
    </ul>
</div>
