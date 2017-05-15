<?php
    get_header();
    $filters = get_riggdata_filters();
    $riggdataItems = get_riggdata_objects();
?>

<div class="container">
    <div id="filterRiggPage" class="completeContentContainer">
        <div class="navInfo">
            Riggdata
        </div>
        <div class="mainContentArea">
            <h1>Rigger i Nord-Europa</h1>

            <table id="oversiktTable" class="mainContentHolder footable" data-filter="#nameFilter" data-filter-minimum="1" data-filter-timeout="1">
                <thead id="sortingHead">
                <tr>
                    <th class="rigName" data-sort-initial="ascending">Rigg</th>
                    <th class="rigStatus" data-hide="phone, portrait, landscape">Status</th>
                    <th class="rigOwner" data-hide="phone, portrait">Eier</th>
                    <th class="rigOperator">Operatør</th>
                    <th class="rigType" data-hide="phone, portrait, landscape">Type</th>
                    <th class="rigSector" data-hide="phone, portrait, landscape">Sektor</th>
                    <th class="rigRate" data-hide="phone, portrait">Dagrate</th>
                </tr>
                </thead>
                <thead id="filteringHead">
                <tr class="summaryRow">
                    <td><input type="text" id="nameFilter" class="footable-filter" data-filter-columns=".filter-name"></td>
                    <td class="visible-lg">
                        <select id="statusFilter" class="footable-filter" data-filter-columns=".filter-status">
                            <?php echo get_riggdata_filter_options($filters['status']); ?>
                        </select>
                    </td>

                    <td class=" visible-md visible-lg">
                        <select id="ownerFilter" class="footable-filter" data-filter-columns=".filter-owner">
                            <?php echo get_riggdata_filter_options($filters['owner']); ?>
                        </select>
                    </td>

                    <td>
                        <select id="operatorFilter" class="footable-filter" data-filter-columns=".filter-operator">
                            <?php echo get_riggdata_filter_options($filters['operator']); ?>
                        </select>
                    </td>

                    <td class="visible-lg">
                        <select id="typeFilter" class="footable-filter" data-filter-columns=".filter-type">
                            <?php echo get_riggdata_filter_options($filters['type']); ?>
                        </select>
                    </td>

                    <td class="visible-lg">
                        <select id="sectorFilter" class="footable-filter" data-filter-columns=".filter-sector">
                            <?php echo get_riggdata_filter_options($filters['sector']); ?>
                        </select>
                    </td>

                    <td class="visible-md visible-lg"></td>
                </tr>

                <tr class="summaryRow summaryTop">
                    <td class="riggCounter"></td>
                    <td class="visible-lg"></td>
                    <td class="visible-md visible-lg"></td>
                    <td></td>
                    <td class="visible-lg"></td>
                    <td class="visible-lg"></td>
                    <td class="rigRate visible-md visible-lg"></td>
                </tr>
                <tr class="hidden"></tr>
                </thead>

                <tbody>
                <?php foreach ($riggdataItems as $item) : ?>
                    <tr>
                        <td class="rigName filter-name">
                            <a href="?navn=<?php echo $item['rig_id'] ?>"><?php echo $item['name'] ?></a>
                        </td>
                        <td class="rigStatus filter-status">
                            <?php echo $item['status'] ?>
                        </td>
                        <td class="rigOwner filter-owner">
                            <?php echo $item['owner']['name']; ?>
                        </td>
                        <td class="rigOperator filter-operator">
                            <?php echo $item['operator']['name']; ?>
                        </td>
                        <td class="rigType filter-type">
                            <?php echo $item['type'] ?>
                        </td>
                        <td class="rigSector filter-sector">
                            <?php echo $item['sector']; ?>
                        </td>
                        <td class="rigRate filter-rate">
                            <?php echo $item['day_rate']; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr class="summaryRow summaryBottom">
                    <td class="riggCounter"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="rigRate"></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<?php get_footer(); ?>
