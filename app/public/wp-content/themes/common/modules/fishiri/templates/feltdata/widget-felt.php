<?php
    $feltItems = $__data['felts'];
?>

<div class="fishiri-text">
    Felt omtalt i saken
</div>
<div class="row">
    <?php foreach ($feltItems as $feltItem): ?>
        <?php if ($feltItem['name'] == '') { continue; } ?>
        <?php $slug_felt_name = preg_replace("/[^A-Za-z0-9]/", '', $feltItem['name']); ?>
        <div class="col-sm-6">
            <div class="feltdata-block">
                <div>
                    <div class="head">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#felt-<?php echo $slug_felt_name; ?>" aria-controls="felt-<?php echo $slug_felt_name; ?>" aria-expanded="false">
                            <div class="icon category-background">
                                <?php get_felt_icon($feltItem['status']); ?>
                            </div>
                            <div class="title felt-name"><?php echo $feltItem['name']; ?></div>
                            <div class="arrow">
                                <?php insert_svg('fishiri/arrow-down.svg'); ?>
                            </div>
                        </a>
                    </div>
                    <div id="felt-<?php echo $slug_felt_name; ?>" class="content">
                        <table>
                            <tr>
                                <td>Felt</td>
                                <td><?php echo $feltItem['name']; ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td class="category-color"><?php echo $feltItem['status']; ?></td>
                            </tr>
                            <tr>
                                <td>Operator</td>
                                <td><?php echo $feltItem['operator']['name']; ?></td>
                            </tr>
                            <tr>
                                <td>Lokasjon</td>
                                <td><?php echo $feltItem['location']; ?></td>
                            </tr>
                        </table>
                        <div class="button-wrapper">
                            <a href="/offshore/feltdata?navn=<?php echo $feltItem['name']; ?>" class="button category-background">LES MER</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>