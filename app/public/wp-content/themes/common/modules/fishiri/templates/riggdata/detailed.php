<?php
    get_header();
    $riggdataItem = get_single_riggdata_object();
?>
<div class="container">
    <div id="detailedRiggPage" class="completeContentContainer">
        <div class="navInfo titleField">
            <a href="?">Riggdata</a> &gt; <?php echo $riggdataItem['riggData']['name'] ?>
        </div>
        <div class="mainContentArea">
            <h1>
                <?php echo $riggdataItem['riggData']['name']; ?>
            </h1>
            <h2>
                <?php echo $riggdataItem['riggData']['type'] ?> - <?php echo $riggdataItem['riggData']['status']; ?>
            </h2>
            <div class="mainContentHolder">
                <div class="beskrivelseInfoHolder">
                    <div id="beskrivelseHolder" class="col-xs-12 col-sm-4">
                        <table>
                            <tbody>
                            <tr>
                                <td class="title">Type:</td>
                                <td class="value"><?php echo $riggdataItem['riggData']['type']; ?> </td>
                            </tr>
                            <tr>
                                <td class="title">Status:</td>
                                <td class="value"><?php echo $riggdataItem['riggData']['status']; ?> </td>
                            </tr>
                            <tr>
                                <td class="title">Contract:</td>
                                <td class="value"><?php echo $riggdataItem['riggData']['operator']['name']; ?> </td>
                            </tr>
                            <tr>
                                <td class="title">Sector:</td>
                                <td class="value"><?php echo $riggdataItem['riggData']['sector']; ?> </td>
                            </tr>
                            <tr>
                                <td class="title">Owner:</td>
                                <td class="value"><?php echo $riggdataItem['riggData']['owner']['name']; ?> </td>
                            </tr>
                            <tr>
                                <td class="title">Water depth:</td>
                                <td class="value"><?php echo $riggdataItem['riggData']['rig_ratings']['maximum_water_depth']; ?> </td>
                            </tr>
                            <tr>
                                <td class="title">Max drill:</td>
                                <td class="value"><?php echo $riggdataItem['riggData']['rig_ratings']['maximum_drilling_depth']; ?> </td>
                            </tr>
                            <tr>
                                <td class="title">Day rate:</td>
                                <td class="value"><?php echo $riggdataItem['riggData']['day_rate']; ?> </td>
                            </tr>
                            <tr>
                                <td class="title">Comments:</td>
                                <td class="value"><?php echo $riggdataItem['riggData']['comment']; ?> </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="sectorImage col-xs-12 col-sm-4">
                        <img src="<?php draw_riggdata_sector_image($riggdataItem['riggData']['sector']); ?>" alt="Rig area map"/>
                    </div>
                    <?php if($riggdataItem['riggData']['gallery']['gallery_items'][0] != ''): ?>
                        <div id="riggGallery" class="carousel slide" data-interval="false">
                            <!-- Carousel items -->
                            <div class="carousel-inner">
                                <?php foreach ($riggdataItem['riggData']['gallery']['gallery_items'] as $image => $value) : ?>
                                    <div class="item<?php echo ($image == 0 ? ' active' : '') ?>" item-id="<?php echo ($image + 1) ?>">
                                        <img src="<?php echo $value['media']['s3_url'] ?>" alt="<?php echo $riggdataItem['riggData']['name'] ?> image" />
                                    </div>
                                <?php endforeach;?>
                            </div>
                            <!-- Carousel nav -->
                            <div class="carousel-controls">
                                <a class="carousel-previous" href="#riggGallery" data-slide="prev"></a>
                                <span id="imagesCount"></span>
                                <a class="carousel-next" href="#riggGallery" data-slide="next"></a>
                            </div>
                        </div>
                    <?php endif;?>
                    <div class="clearfix"></div>
                </div>
                <div class="beskrivelseInfoHolder detailsHolder">
                    <h3><?php echo $riggdataItem['riggData']['name'] ?> Specifications</h3>
                    <div id="sectionButtons">
                        <a href="#" id="showAll">show all</a> / <a href="#" id="hideAll">hide all</a>
                    </div>
                    <div class="detailSection">
                        <div class="sectionInfo">
                            <a href="#" class="header">
                                <span class="plusButton">+</span>
                                <span class="minusButton">-</span>
                                <span class="sectionTitleText">Rig information</span>
                            </a>
                            <table>
                                <tbody>
                                <tr>
                                    <td class="title">Vessel type:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['rig_information']['vessel_type']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Vessel design:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['rig_information']['vessel_design']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Construction date:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['rig_information']['construction_date']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Upgrade date:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['rig_information']['update_date']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Classification:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['rig_information']['classification']; ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="sectionInfo">
                            <a href="#" class="header">
                                <span class="plusButton">+</span>
                                <span class="minusButton">-</span>
                                <span class="sectionTitleText">Rig Ratings</span>
                            </a>
                            <table>
                                <tbody>
                                <tr>
                                    <td class="title">Maximum water depth rating:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['rig_ratings']['maximum_water_depth']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Maximum drilling depth:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['rig_ratings']['maximum_drilling_depth']; ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="sectionInfo">
                            <a href="#" class="header">
                                <span class="plusButton">+</span>
                                <span class="minusButton">-</span>
                                <span class="sectionTitleText">Vessel particulars</span>
                            </a>
                            <table>
                                <tbody>
                                <tr>
                                    <td class="title">Total vessel power:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['vessel_particulars']['total_vessel_power']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Maximum vessel speed(transit speed):</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['vessel_particulars']['maximum_vessel_speed']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Quarters capacity:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['vessel_particulars']['quarters_capacity']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Length:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['vessel_particulars']['length']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Width:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['vessel_particulars']['width']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Transit draft:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['vessel_particulars']['transit_draft']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Operation draft:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['vessel_particulars']['operation_draft']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Maximum variable load (operating/survival):</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['vessel_particulars']['maximum_variable_load']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Moonpool size (ft. X ft):</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['vessel_particulars']['moonpool_size']; ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="sectionInfo">
                            <a href="#" class="header">
                                <span class="plusButton">+</span>
                                <span class="minusButton">-</span>
                                <span class="sectionTitleText">Vessel particulars continued</span>
                            </a>
                            <table>
                                <tbody>
                                <tr>
                                    <td class="title">Thrusters (No. And H.P):</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['vessel_particulars_continued']['thrusters']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Size of chain</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['vessel_particulars_continued']['size_of_chain']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Length of chain:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['vessel_particulars_continued']['length_of_chain']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Wire rope diameter:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['vessel_particulars_continued']['wire_rope_diameter']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Length of wire rope:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['vessel_particulars_continued']['length_of_wire_rope']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Anchor size (No x M.T):</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['vessel_particulars_continued']['anchor_size']; ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="sectionInfo">
                            <a href="#" class="header">
                                <span class="plusButton">+</span>
                                <span class="minusButton">-</span>
                                <span class="sectionTitleText">Lifting equipment</span>
                            </a>
                            <table>
                                <tbody>
                                <tr>
                                    <td class="title">Pedestal crane 1:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['lifting_equipment']['pedestal_crane1']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Pedestal crane 2:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['lifting_equipment']['pedestal_crane2']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Pedestal crane 3:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['lifting_equipment']['pedestal_crane3']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Pedestal crane 4:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['lifting_equipment']['pedestal_crane4']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Riser handling crane:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['lifting_equipment']['riser_handling_crane']; ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="sectionInfo">
                            <a href="#" class="header">
                                <span class="plusButton">+</span>
                                <span class="minusButton">-</span>
                                <span class="sectionTitleText">Drilling equipment</span>
                            </a>
                            <table>
                                <tbody>
                                <tr>
                                    <td class="title">Derrick rating:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['drilling_equipment']['derrick_rating']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Derrick manufacturer:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['drilling_equipment']['derrick_manufacturer']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Derrick footprint (ft. X ft. X ft):</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['drilling_equipment']['derrick_footprint']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Drawworks:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['drilling_equipment']['drawworks_power']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Drawworks:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['drilling_equipment']['drawworks_manufacturer']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Drill line size:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['drilling_equipment']['drill_line_size']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Rotary table size:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['drilling_equipment']['rotary_table_size']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Iron roughneck:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['drilling_equipment']['iron_roughneck']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Top drive:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['drilling_equipment']['top_drive']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Heave compensator(motion compensator):</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['drilling_equipment']['heave_compensator_manufacturer']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Heave compensator capacity (operating/pinned):</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['drilling_equipment']['heave_compensator_capacity']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Pipe racking system:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['drilling_equipment']['pipe_racking_system']; ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="sectionInfo">
                            <a href="#" class="header">
                                <span class="plusButton">+</span>
                                <span class="minusButton">-</span>
                                <span class="sectionTitleText">Mud systems</span>
                            </a>
                            <table>
                                <tbody>
                                <tr>
                                    <td class="title">Mud pumps:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['mud_systems']['mud_pumps_number']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Mud Pumps:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['mud_systems']['mud_pumps_manufacturer_and_model']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Liquid Mud:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['mud_systems']['liquid_mud']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Fuel Oil:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['mud_systems']['fuel_oil']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Bulk storage capacity (mud/cement or total):</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['mud_systems']['bulk_storage_capacity']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Shale shakers:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['mud_systems']['shale_shakers']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Desander:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['mud_systems']['desander']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Desilter:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['mud_systems']['desilter']; ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="sectionInfo">
                            <a href="#" class="header">
                                <span class="plusButton">+</span>
                                <span class="minusButton">-</span>
                                <span class="sectionTitleText">Riser & Riser tensioner data</span>
                            </a>
                            <table>
                                <tbody>
                                <tr>
                                    <td class="title">Riser tensioner(total capacity):</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['riser_and_riser_tensioner_data']['riser_tensioners_total_capacity']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Riser tensioners:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['riser_and_riser_tensioner_data']['riser_tensioners_number']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Riser tensioners:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['riser_and_riser_tensioner_data']['riser_tensioners_manufacturer']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Diverter size:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['riser_and_riser_tensioner_data']['diverter_size']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Riser size:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['riser_and_riser_tensioner_data']['riser_size']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Riser joint length:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['riser_and_riser_tensioner_data']['riser_joint_length']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Riser manufacturer:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['riser_and_riser_tensioner_data']['riser_manufacturer']; ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="sectionInfo">
                            <a href="#" class="header">
                                <span class="plusButton">+</span>
                                <span class="minusButton">-</span>
                                <span class="sectionTitleText">BOP & BOP control data</span>
                            </a>
                            <table>
                                <tbody>
                                <tr>
                                    <td class="title">BOP Operating pressure:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['bop_and_bop_control_data']['bop_operating_pressure']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">C&K line size:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['bop_and_bop_control_data']['ck_line_size']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Ram BOP's:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['bop_and_bop_control_data']['ram_bops_number']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Ram BOP's:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['bop_and_bop_control_data']['ram_bops_manufacturer']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Annular BOP's:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['bop_and_bop_control_data']['annular_bops_number']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Annular BOP's:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['bop_and_bop_control_data']['annular_bops_manufacturer']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">Wellhead connector:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['bop_and_bop_control_data']['wellhead_connector_type']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">BOP control system:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['bop_and_bop_control_data']['bop_control_system_type']; ?></td>
                                </tr>
                                <tr>
                                    <td class="title">BOP control system:</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['bop_and_bop_control_data']['bop_control_system_manufacturer']; ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="sectionInfo">
                            <a href="#" class="header">
                                <span class="plusButton">+</span>
                                <span class="minusButton">-</span>
                                <span class="sectionTitleText">Landing facilities</span>
                            </a>
                            <table>
                                <tbody>
                                <tr>
                                    <td class="title">Helideck (type):</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['landing_facilities']['helideck_type']; ?></td>
                                </tr>
    
                                <tr>
                                    <td class="title">Helideck size (ft. x ft.):</td>
                                    <td class="value"><?php echo $riggdataItem['riggData']['landing_facilities']['helideck_size']; ?></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <h3 class="perspective"><?php echo $riggdataItem['riggData']['name'] ?> in Perspective</h3>
                    <div class="detailSection">
                        <div class="sectionInfo">
                            <a href="#" class="header">
                                <span class="plusButton">+</span>
                                <span class="minusButton">-</span>
                                <span class="sectionTitleText">Contract history</span>
                            </a>
                            <table id="contracts" class="footable" data-filter="false">
                                <thead>
                                <tr>
                                    <th>Status</th>
                                    <th>Operator</th>
                                    <th>Start</th>
                                    <th>End</th>
                                    <th>DayRate</th>
                                    <th>Comment</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php draw_contract_information($riggdataItem['riggData']['contract_information']); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="sectionInfo">
                            <a href="#" class="header">
                                <span class="plusButton">+</span>
                                <span class="minusButton">-</span>
                                <span class="sectionTitleText">Rigs owned by <?php echo $riggdataItem['riggData']['owner']['name'] ?> ( <?php echo $riggdataItem['connectedRigs']['byOwner']['count']; ?> )  </span>
                            </a>
                            <ul class="operated">
                                <?php draw_related_rigs($riggdataItem['connectedRigs']['byOwner']['items']); ?>
                            </ul>
                        </div>
                        <div class="sectionInfo">
                            <a href="#" class="header">
                                <span class="plusButton">+</span>
                                <span class="minusButton">-</span>
                                <span class="sectionTitleText">Rigs operated by <?php echo $riggdataItem['riggData']['operator']['name'] ?> ( <?php echo $riggdataItem['connectedRigs']['byOperator']['count']; ?> ) </span>
                            </a>
                            <ul class="operated">
                                <?php draw_related_rigs($riggdataItem['connectedRigs']['byOperator']['items']); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mainContentArea">
            <div class="mainContentHolder">
                <div class="beskrivelseInfoHolder detailsHolder">
                    <h3><?php echo $riggdataItem['riggData']['name']; ?> - nyheter fra feltet</h3>
                    <div class="connectedArticles" role="tabpanel">
                        <ul class="nav nav-tabs" role="tablist">
                            <?php foreach ($riggdataItem['articles'] as $connected_data):
                                $category = $connected_data['category'];
                                $active_class = ($category['slug'] == 'all') ? 'class="active"' : '';
                                ?>
                                <li role="presentation" <?php echo $active_class; ?>><a href="#<?php echo $category['slug']; ?>" aria-controls="<?php echo $category['slug']; ?>" role="tab" data-toggle="tab"><?php echo $category['name']; ?> (<?php echo $connected_data['article_query']->found_posts; ?>)</a></li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="tab-content">
                            <?php foreach ($riggdataItem['articles'] as $connected_data):
                                $category = $connected_data['category'];
                                $article_query = $connected_data['article_query'];
                                ?>
                                <div role="tabpanel" class="tab-pane <?php echo ($category['slug'] == 'all' ? 'active' : ''); ?>" id="<?php echo $category['slug']; ?>">
                                    <ul class="articlesList">
                                        <?php while($article_query->have_posts()) : $article_query->the_post();?>
                                            <li>
                                                <a href="<?php the_permalink(); ?>">
                                                    <em><?php the_time('d.m.Y'); ?></em>
                                                    <div class="article">
                                                        <div class="title" title="<?php the_title_attribute();?>"><?php the_title(); ?></div>
                                                        <div class="excerpt"><?php the_excerpt(); ?></div>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php endwhile; ?>
                                    </ul>
                                    <?php if($article_query->have_posts()) : ?>
                                        <div class="tabButtons">
                                            <a href="<?php echo esc_url( home_url( '/' ) ) . 'offshore/riggsaker/' . $category['slug'] . '/' . urlencode($riggdataItem['riggData']['name']); ?>" title="Alle">Alle ↓</a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>
