<?php
    $mailchimpLists = get_mailchimp_lists();
    $listsToDisplay = ['6827bcf0e0', '9eefb6c927', '6b2209af71', 'a71122a659', '7622d09f15'];
?>
<div class="nyhetsbrev-section">
    <div class="nyhetsbrev-title">Nyhetsbrev</div>
    <?php foreach ($mailchimpLists as $list) : ?>
        <?php if (in_array($list->id, $listsToDisplay)) : ?>
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="<?php echo $list->id?>" autocomplete="off">
                    <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>
                    <img src="<?php module_img('profile/ajax-loader.gif');?>" class="loader hidden" />
                    <span class="subscription-name"><?php echo $list->name?></span>
                </label>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>