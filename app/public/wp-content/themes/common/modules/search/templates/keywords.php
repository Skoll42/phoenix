<?php
    $tags = get_most_used_tags();
    $isMobile = !empty($__data['mobile']) && $__data['mobile'];
?>
<div class="search-categories<?php echo $isMobile ? '-mobile' : ''; ?>">
    <div class="search-title">Foreslåtte søkeord</div>
    <div class="categories-list">
        <?php $count = 0; ?>
        <?php foreach ($tags as $tag) : ?>
            <?php $count++; ?>
            <a href="#" class="category-name <?php echo $count > 8 ? ' hidden-xs hidden-sm hidden-md' : ''?>" data-value="<?php echo $tag->slug; ?>"><?php echo $tag->slug; ?></a>
        <?php endforeach; ?>
    </div>
</div>