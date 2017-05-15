<?php if (bt_article_content_is_element('bio')): ?>
    <div class="article-content-bio">
        <div class="image">
            <?php echo $__data['bio_img']; ?>
        </div>
        <div class="name">
            <?php echo $__data['bio_name']; ?>
        </div>
        <div class="description">
            <?php echo $__data['bio']; ?>
        </div>
    </div>
<?php endif; ?>

