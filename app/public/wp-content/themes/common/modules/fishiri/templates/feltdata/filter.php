<?php
    get_header();
    $filters = get_feltdata_filters();
    $feltdataItems = get_feltdata_objects();
?>
<div class="container feltdataContainer">
    <div id="filterFeltPage" class="completeContentContainer">
        <div class="navInfo">Feltdata</div>
        <div class="mainContentArea">
            <h1>FELT OG PROSJEKTER PÅ NORSK SOKKEL</h1>

            <table id="oversiktTable" class="mainContentHolder footable" data-filter="#nameFilter" data-filter-minimum="1" data-filter-timeout="1">
                <thead id="sortingHead">
                <tr>
                    <th class="feltName" data-sort-initial="ascending">Felt</th>
                    <th class="feltOperator" data-hide="phone, portrait">Operatør</th>
                    <th class="feltStatus" data-hide="phone, portrait, landscape">Status</th>
                    <th class="feltLocation" data-hide="phone, portrait, landscape">Lokasjon</th>
                    <th class="feltInvests">Gjenstående Investeringer</th>
                </tr>
                </thead>
                <thead id="filteringHead">
                <tr class="summaryRow">
                    <td><input type="text" id="nameFilter" class="footable-filter" data-filter-columns=".filter-name"></td>

                    <td class="visible-md visible-lg">
                        <select id="operatorFilter" class="footable-filter" data-filter-columns=".filter-operator">
                            <?php echo get_riggdata_filter_options($filters['operator']); ?>
                        </select>
                    </td>

                    <td class="visible-lg">
                        <select id="statusFilter" class="footable-filter" data-filter-columns=".filter-status">
                            <?php echo get_riggdata_filter_options($filters['status']); ?>
                        </select>
                    </td>

                    <td class="visible-lg">
                        <select id="locationFilter" class="footable-filter" data-filter-columns=".filter-location">
                            <?php echo get_riggdata_filter_options($filters['location']); ?>
                        </select>
                    </td>

                    <td></td>
                </tr>

                <tr class="summaryRow summaryTop">
                    <td class="feltCounter"></td>
                    <td class="visible-md visible-lg"></td>
                    <td class="visible-lg"></td>
                    <td class="visible-lg"></td>
                    <td class="feltInvests"></td>
                </tr>
                <tr class="hidden"></tr>
                </thead>

                <tbody>

                <?php foreach ($feltdataItems as $item) : ?>
                    <tr>
                        <td class="feltName filter-name">
                            <a href="?navn=<?php echo $item['name']; ?>"><?php echo $item['name'];?></a>
                        </td>
                        <td class="feltOperator filter-operator">
                            <?php echo $item['operator']['name']; ?>
                        </td>
                        <td class="feltStatus filter-status">
                            <?php echo $item['status']; ?>
                        </td>
                        <td class="feltLocation filter-location">
                            <?php echo $item['location']; ?>
                        </td>
                        <td class="feltInvests filter-Invests">
                            <?php echo format_money($item['investments']['remaining_investments']); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
                <tfoot>
                <tr class="summaryRow summaryBottom">
                    <td class="feltCounter"></td>
                    <td class="visible-md visible-lg"></td>
                    <td class="visible-lg"></td>
                    <td class="visible-lg"></td>
                    <td class="feltInvests"></td>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<?php get_footer(); ?>