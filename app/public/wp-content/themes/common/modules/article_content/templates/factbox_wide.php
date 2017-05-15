<div class="article-content-factbox factbox-wide">
    <div class="accordion" id="factbox-accordion-<?php echo $__data['factbox_id']; ?>">
      <div class="accordion-group">
        <div class="accordion-heading">
          <span class="head-text">Fakta</span>
          <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#factbox-accordion-<?php echo $__data['factbox_id']; ?>"
             href="#collapse-<?php echo $__data['factbox_id']; ?>">
            <span class="closed">Forlenge</span>
            <span class="opened">Lukke</span>
            <?php insert_svg('article_content/arrow-down.svg'); ?>
          </a>
        </div>
        <div id="collapse-<?php echo $__data['factbox_id']; ?>" class="accordion-body collapse">
          <div class="accordion-inner">
            <div class="content"><?php echo $__data['content']; ?></div>
            <div class="copyright"><?php echo $__data['copyright'];; ?></div>
          </div>
        </div>
      </div>
    </div>
</div>