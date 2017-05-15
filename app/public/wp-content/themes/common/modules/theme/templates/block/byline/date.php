<span class="publish">Publisert <?php echo get_the_date('d.m.Y H:i'); ?></span>
<?php if (get_the_date('U') != the_modified_date('U', '', '', false)): ?>
    / <span class="update">Oppdatert <?php echo the_modified_date('d.m.Y H:i', '', '', false); ?></span>
<?php endif; ?>


