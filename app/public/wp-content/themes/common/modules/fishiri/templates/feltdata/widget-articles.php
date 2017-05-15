<?php
    $feltItem = $__data['feltItem'];
    $isWidgetVisible = isset($feltItem['articles']) && is_array($feltItem['articles']);
?>

<?php if($isWidgetVisible) : ?>
    <div class="timetable-block">
        <div class="head">
            <span class="title"><?php echo $feltItem['name']; ?></span>
        </div>

        <div class="content">
            <ul class="nav nav-tabs tabs" role="tablist">
                <?php foreach ($feltItem['articles'] as $connected_data):
                    $category = $connected_data['category'];
                    $active_class = ($category['slug'] == 'all') ? 'class="active"' : '';
                    ?>
                    <li role="presentation" <?php echo $active_class; ?>><a href="#felt-<?php echo $category['slug']; ?>" aria-controls="felt-<?php echo $category['slug']; ?>" role="tab" data-toggle="tab"><?php echo $category['name']; ?> (<?php echo $connected_data['article_query']->found_posts; ?>)</a></li>
                <?php endforeach;?>
            </ul>
            <div class="tabs-content">
                <?php foreach ($feltItem['articles'] as $connected_data):
                    $category = $connected_data['category'];
                    $article_query = $connected_data['article_query'];
                    ?>
                    <div role="tabpanel" class="tab-pane <?php echo ($category['slug'] == 'all' ? 'in active' : ''); ?>" id="felt-<?php echo $category['slug']; ?>">
                        <table>
                            <?php while($article_query->have_posts()) : $article_query->the_post();?>
                                <tr>
                                    <td><span class="category-color"><?php the_time('d.m.Y'); ?></span></td>
                                    <td><?php the_time('H:i'); ?></td>
                                    <td><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></td>
                                </tr>
                            <?php endwhile; ?>
                        </table>
                        <?php if($article_query->have_posts()) : ?>
                            <div class="button-wrapper">
                                <a href="<?php echo esc_url( home_url( '/' ) ) . 'offshore/feltsaker/' . $category['slug'] . '/' . urlencode($feltItem['name']); ?>" class="button category-background" title="Se alle saker">SE ALLE SAKER</a>
                            </div>
                            <div class="clearfix"></div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>