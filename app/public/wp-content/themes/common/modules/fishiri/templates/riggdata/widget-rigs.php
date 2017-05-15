<?php
    $rigs = $__data['rigs'];
?>

<div class="fishiri-text">
    Rigger omtalt i saken
</div>
<div class="row">
    <?php foreach ($rigs as $rigItem): ?>
        <?php if ($rigItem['name'] == '') { continue; } ?>
        <?php $slug_rigg_name = preg_replace("/[^A-Za-z0-9]/", '', $rigItem['name']); ?>
        <div class="col-sm-6">
            <div class="riggdata-block">
                <div>
                    <div class="head">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#rigg-<?php echo $slug_rigg_name; ?>" aria-controls="rigg-<?php echo $slug_rigg_name; ?>" aria-expanded="false">
                            <div class="icon category-background">
                                <?php insert_svg('fishiri/' . ($rigItem['status'] == 'Active' ? 'gear.svg' : 'anchor.svg')); ?>
                            </div>
                            <div class="title rig-name"><?php echo $rigItem['name']; ?></div>
                            <div class="arrow">
                                <?php insert_svg('fishiri/arrow-down.svg'); ?>
                            </div>
                        </a>
                    </div>
                    <div id="rigg-<?php echo $slug_rigg_name; ?>" class="content">
                        <div class="text"><?php echo $rigItem['owner']['name']; ?></div>
                        <table>
                            <tr>
                                <td>Rig</td>
                                <td><?php echo $rigItem['name']; ?></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td class="category-color"><?php echo $rigItem['status']; ?></td>
                            </tr>
                            <tr>
                                <td>Operator</td>
                                <td><?php echo $rigItem['operator']['name']; ?></td>
                            </tr>
                            <tr>
                                <td>Dagrate</td>
                                <td><?php echo $rigItem['day_rate']; ?></td>
                            </tr>
                        </table>
                        <div class="button-wrapper">
                            <a href="/offshore/riggdata?navn=<?php echo $rigItem['rig_id']; ?>" class="button category-background">LES MER</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>