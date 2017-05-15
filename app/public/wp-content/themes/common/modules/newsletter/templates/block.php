<?php
    $mailchimpLists = get_mailchimp_lists();
    $listsToDisplay = [
        '6827bcf0e0' => 'sysla',
        '9eefb6c927' => 'gronn',
        '7622d09f15' => 'jobb',
        '6b2209af71' => 'offshore',
        'a71122a659' => 'maritim',
    ];
?>

<div class="newsletter-block category-border-bottom">
    <form class="newsletter-form">
        <div class="subscribe-title">SYSLA NYHETSBREV</div>
        <div class="subscribe-list">
            <div class="subscribe-row">
                <?php $i = 1; ?>
                <?php foreach ($listsToDisplay as $id => $alias) : ?>
                    <?php if (!empty($mailchimpLists[$id])) : ?>
                        <label class="stylized-checkbox subscribe-cell">
                            <input type="checkbox" name="lists[]" value="<?php echo $id; ?>" autocomplete="off" />
                            <span class="category-background"><?php insert_svg('newsletter/check-mark.svg'); ?></span>
                            <span class="subscribe-logo subscribe-logo-<?php echo $alias; ?>">
                                <?php insert_svg(bt_header_get_section_logo($alias)); ?>
                            </span>
                        </label>
                        <?php if ($i % 3 == 0) : ?></div><div class="subscribe-row"><?php endif; ?>
                        <?php $i++; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="subscribe-bottom-title">MORGENNYHETER SOM GIR DEG ET FORSPRANG</div>
        <?php /* TODO: we will need this block later
        <div class="subscribe-agree">
            <label for="agree-sub" class="agree-sub stylized-checkbox">
                <input type="checkbox" id="agree-sub" name="agreement" class="newsletter-agree" />
                <span class="category-background"><?php insert_svg('newsletter/check-mark.svg'); ?></span>
                Jeg har lest og godtar <a href="#" class="category-color">vilkårene for bruk</a> og
                <a href="#" class="category-color">retningslinjer for personvern.</a>
            </label>
        </div>
        */ ?>
        <div class="subscribe-email">
            <input type="email" required placeholder="E-postadresse" name="e-mail" class="newsletter-email category-border" />
            <div class="subscribe-button">
                <input type="submit" class="category-background category-border" value="abonnere" />
            </div>
        </div>
        <div class="subscribe-message"></div>
    </form>
</div>
