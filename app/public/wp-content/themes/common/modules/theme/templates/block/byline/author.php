<?php
    $authors = bt_custom_authors_get_authors();
    $author_id = (count($authors) == 1 && isset($authors[0]) && $authors[0]['ID']) ? $authors[0]['ID'] : null;

    if ($author_id) {
        $avatar_size = 55;
        if (function_exists('mt_profile_img')) {
            $avatar = mt_profile_img($author_id, array(
                    'size' => array($avatar_size, $avatar_size),
                    'echo' => false
                )
            );
        } else {
            $avatar = get_avatar($author_id, $avatar_size);
        }
    } else {
        $avatar = null;
    }
?>

<?php if ($avatar): ?>
   <div class="left">
        <div class="author-image">
            <?php echo $avatar; ?>
        </div>
   </div>
<?php endif; ?>

<div class="right">
    <?php if (!empty($authors)): ?>
        <div class="author">
            <?php module_template('custom_author/authors'); ?>
        </div>
    <?php endif; ?>
    <div class="date">
        <?php module_template('theme/block/byline/date'); ?>
    </div>
</div>


