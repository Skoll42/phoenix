<?php $authors = bt_custom_authors_get_authors(); ?>
<?php if ($authors): ?>
    <?php if (get_post_type() == 'sponsored') : ?>Skrevet av<?php else: ?>av<?php endif; ?>
    <?php foreach($authors as $author): ?>
        <?php if (isset($author['email']) && $author['email']): ?>
            <a href="mailto:<?php echo $author['email']; ?>">
                <?php echo $author['name']; ?>
            </a>
        <?php elseif ($author['name']) : ?>
            <span><?php echo $author['name']; ?></span>
        <?php endif; ?>
    <?php endforeach; ?>
<?php endif; ?>
