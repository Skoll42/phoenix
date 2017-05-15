<?php
if (bt_archive_is_category_fronted()) {
    $layout = bt_archive_get_current_category()->slug;
} else {
    $layout = 'unfronted';
}
?>
<div class="visible-xs">
    <?php module_template('theme/archive/' . $layout . '/mobile'); ?>
</div>
<div class="visible-sm">
    <?php module_template('theme/archive/' . $layout . '/tablet'); ?>
</div>
<div class="visible-md visible-lg">
    <?php module_template('theme/archive/' . $layout . '/desktop'); ?>
</div>
