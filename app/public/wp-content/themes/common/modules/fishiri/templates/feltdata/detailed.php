<?php
    get_header();
    $feltdataItem = get_single_feltdata_object();
?>
<div class="container feltdataContainer">
    <div id="detailedFeltPage" class="completeContentContainer row">
        <div class="navInfo ">
            <a href="?">Feltdata</a> &gt; <?php echo $feltdataItem['feltData']['name']; ?>
        </div>
    
        <div class="mainContentArea col-xs-12 col-sm-8">
            <h1><?php echo $feltdataItem['feltData']['name']; ?></h1>
    
            <div class="feltDescription"><?php echo $feltdataItem['feltData']['description']; ?></div>
            <div class="contact">
                <a href="mailto:redaksjonen@offshore.no">Tips oss om endringer eller nye ideer.</a>
            </div>
            <div class="titleField"><h2>Nøkkeldata</h2></div>
    
            <div class="mainContentHolder">
                <div class="beskrivelseInfoHolder">
                    <div id="beskrivelseHolder" class="col-xs-12 col-sm-6">
                        <table>
                            <tbody>
                                <tr>
                                    <td class="title">Status:</td>
                                    <td class="value"><?php echo $feltdataItem['feltData']['status']; ?> </td>
                                </tr>
                                <tr>
                                    <td class="title">Operatør:</td>
                                    <td class="value"><?php echo $feltdataItem['feltData']['operator']['name']; ?> </td>
                                </tr>
                                <tr>
                                    <td class="title">Funnår:</td>
                                    <td class="value"><?php echo $feltdataItem['feltData']['discovery_year']; ?> </td>
                                </tr>
                                <tr>
                                    <td class="title">Prod. start:</td>
                                    <td class="value"><?php echo $feltdataItem['feltData']['on_stream']; ?> </td>
                                </tr>
                                <tr>
                                    <td class="title">Prod. lisens:</td>
                                    <td class="value"><?php echo $feltdataItem['feltData']['production_license']; ?> </td>
                                </tr>
                                <tr>
                                    <td class="title">Lokasjon:</td>
                                    <td class="value"><?php echo $feltdataItem['feltData']['location']; ?> </td>
                                </tr>
                                <tr>
                                    <td class="title">Vanndybde (m):</td>
                                    <td class="value"><?php echo $feltdataItem['feltData']['water_depth']; ?> </td>
                                </tr>
                                <tr>
                                    <td class="title">Hovedutbygging:</td>
                                    <td class="value"><?php echo $feltdataItem['feltData']['field_development']['production_structure']; ?> </td>
                                </tr>
                                <tr>
                                    <td class="title">Totale investeringer:</td>
                                    <td class="value"><?php echo format_money($feltdataItem['feltData']['investments']['total_investments']); ?> </td>
                                </tr>
                                <tr>
                                    <td class="title">Gjenstående investeringer:</td>
                                    <td class="value"><?php echo format_money($feltdataItem['feltData']['investments']['remaining_investments']); ?> </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
    
                    <div class="sectorImage col-xs-12 col-sm-6">
                        <img src="<?php draw_feltdata_sector_image($feltdataItem['feltData']['location']); ?>" alt="Felt area map"/>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <h3><?php echo $feltdataItem['feltData']['name']; ?> - nyheter fra feltet</h3>
                <div class="connectedArticles" role="tabpanel">
                    <ul class="nav nav-tabs" role="tablist">
                        <?php foreach ($feltdataItem['articles'] as $connected_data):
                                $category = $connected_data['category'];
                                $active_class = ($category['slug'] == 'all') ? 'class="active"' : '';
                            ?>
                            <li role="presentation" <?php echo $active_class; ?>><a href="#<?php echo $category['slug']; ?>" aria-controls="<?php echo $category['slug']; ?>" role="tab" data-toggle="tab"><?php echo $category['name']; ?> (<?php echo $connected_data['article_query']->found_posts; ?>)</a></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="tab-content">
                        <?php foreach ($feltdataItem['articles'] as $connected_data):
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
                                        <a href="<?php echo esc_url( home_url( '/' ) ) . 'offshore/feltsaker/' . $category['slug'] . '/' . urlencode($feltdataItem['feltData']['name']); ?>" title="Alle">Alle ↓</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-4">
            <div class="mainContentAreaRight">
                <?php if($feltdataItem['feltData']['gallery']['gallery_items'][0] != ''): ?>
                    <h3>Image gallery</h3>
                    <div id="feltGallery" class="carousel slide" data-interval="false">
                        <!-- Carousel items -->
                        <div class="carousel-inner">
                            <?php foreach ($feltdataItem['feltData']['gallery']['gallery_items'] as $image => $value) : ?>
                                <div class="item<?php echo ($image == 0 ? ' active' : '') ?>" item-id="<?php echo ($image + 1) ?>">
                                    <img src="<?php echo $value['media']['s3_url'] ?>" alt="<?php echo $feltdataItem['feltData']['name'] ?> image" />
                                </div>
                            <?php endforeach;?>
                        </div>
                        <!-- Carousel nav -->
                        <div class="carousel-controls">
                            <a class="carousel-previous" href="#feltGallery" data-slide="prev"></a>
                            <span id="imagesCount"></span>
                            <a class="carousel-next" href="#feltGallery" data-slide="next"></a>
                        </div>
                    </div>
                <?php endif;?>
                <h3 class="chartHead">Preliminary vs remaining investments</h3>
    
                <div id="chart_div">
                    <canvas id="pieChart"></canvas>
                </div>
    
                <h3>Investments</h3>
                <table>
                    <tbody>
                        <tr>
                            <td class="title">Total</td>
                            <td class="value"><?php echo format_money($feltdataItem['feltData']['investments']['total_investments']); ?> </td>
                        </tr>
                        <tr>
                            <td class="title">So far</td>
                            <td class="value"><?php echo format_money($feltdataItem['feltData']['investments']['so_far_investments']); ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Remaining inv.</td>
                            <td class="value"><?php echo format_money($feltdataItem['feltData']['investments']['remaining_investments']); ?> </td>
                        </tr>
                    </tbody>
                </table>
    
                <h3>Frame Agreement</h3>
                <table>
                    <tbody>
                        <tr>
                            <td class="title">M&M</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['frame_agreement']['mm']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">M&M contract expires</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['frame_agreement']['mm_contract_expires'];; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">ISO</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['frame_agreement']['iso']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">ISO contract expires</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['frame_agreement']['iso_contract_expires']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Drilling and well</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['frame_agreement']['drilling_and_well']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Drilling and well contract expires</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['frame_agreement']['drilling_and_well_contract_expires']; ?> </td>
                        </tr>
                    </tbody>
                </table>
    
                <h3>Main development concept</h3>
                <table>
                    <tbody>
                        <tr>
                            <td class="title">Production vessel/structure</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['field_development']['production_structure']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Production/Drilling/Quarters</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['field_development']['production_drilling_quarters']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Material</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['field_development']['material']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Additional info</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['field_development']['additional_info']; ?> </td>
                        </tr>
                    </tbody>
                </table>
    
                <h3>Subsea development</h3>
                <table>
                    <tbody>
                        <tr>
                            <td class="title">Subsea company</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['subsea_development']['subsea_company']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Subsea template</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['subsea_development']['subsea_template']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Total trees</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['subsea_development']['total_trees']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">FMC</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['subsea_development']['fmc']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">AKS</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['subsea_development']['aks']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">GE</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['subsea_development']['ge']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">CAM</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['subsea_development']['cam']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Subsea tieback</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['subsea_development']['subsea_tieback']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Tieback distance (km)</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['subsea_development']['tieback_distance']; ?> </td>
                        </tr>
                    </tbody>
                </table>
    
                <h3>Drilling wells</h3>
                <table>
                    <tbody>
                        <tr>
                            <td class="title">Exploration</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['drilling_wells']['exploration']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Development</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['drilling_wells']['development']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Top reservoir depth</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['drilling_wells']['top_reservoir_depth']; ?> </td>
                        </tr>
                    </tbody>
                </table>
    
                <h3>Remaining oil and gas reserves</h3>
                <table>
                    <tbody>
                        <tr>
                            <td class="title">Oil (Sm3)</td>
                            <td class="value"><?php echo pretty_number_format($feltdataItem['feltData']['remaining_reserves']['oil']); ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Oil barrels (bbl)</td>
                            <td class="value"><?php echo pretty_number_format($feltdataItem['feltData']['remaining_reserves']['oil_barrels']); ?> </td>
                        </tr>
                        <tr>
                            <td class="title">At current oil price</td>
                            <td class="value"><?php echo pretty_number_format($feltdataItem['feltData']['remaining_reserves']['at_current_oil_price']); ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Gas (Sm3)</td>
                            <td class="value"><?php echo pretty_number_format($feltdataItem['feltData']['remaining_reserves']['gas']); ?> </td>
                        </tr>
                    </tbody>
                </table>
    
                <h3>Total reserves estimate</h3>
                <table>
                    <tbody>
                        <tr>
                            <td class="title">Oil (Sm3)</td>
                            <td class="value"><?php echo pretty_number_format($feltdataItem['feltData']['total_reserves_estimate']['oil']); ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Gas (Sm3)</td>
                            <td class="value"><?php echo pretty_number_format($feltdataItem['feltData']['total_reserves_estimate']['gas']); ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Condensate (Sm3)</td>
                            <td class="value"><?php echo pretty_number_format($feltdataItem['feltData']['total_reserves_estimate']['condensate']); ?> </td>
                        </tr>
                        <tr>
                            <td class="title">NGL (mt)</td>
                            <td class="value"><?php echo pretty_number_format($feltdataItem['feltData']['total_reserves_estimate']['ngl']); ?> </td>
                        </tr>
                    </tbody>
                </table>
    
                <h3>Export technology</h3>
                <table>
                    <tbody>
                        <tr>
                            <td class="title">Oil</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['export_technology']['oil']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Gas</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['export_technology']['gas']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Condensate</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['export_technology']['condensate']; ?> </td>
                        </tr>
                    </tbody>
                </table>
    
                <h3>Destination</h3>
                <table>
                    <tbody>
                        <tr>
                            <td class="title">Oil</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['destination']['oil']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Gas</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['destination']['gas']; ?> </td>
                        </tr>
                        <tr>
                            <td class="title">Condensate</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['destination']['condensate']; ?> </td>
                        </tr>
                    </tbody>
                </table>
    
                <h3>Supply base</h3>
                <table>
                    <tbody>
                        <tr>
                            <td class="title">Supply base</td>
                            <td class="value"><?php echo $feltdataItem['feltData']['supply_base']; ?> </td>
                        </tr>
                    </tbody>
                </table>
    
                <h3>Videre detaljer</h3>
                <table>
                    <tbody>
                        <tr>
                            <td class="title"><a href="http://www.npd.no/">Fra Oljedirektoratet: </a></td>
                        </tr>
                        <tr>
                            <td class="title">Informasjon</td>
                            <td class="value"><a href="<?php echo $feltdataItem['feltData']['npdid']['facts_link']; ?>">Faktaside</a></td>
                        </tr>
                        <tr>
                            <td class="title">Kart</td>
                            <td class="value"><a href="<?php echo $feltdataItem['feltData']['npdid']['map_link']; ?>">Faktakart</a></td>
                        </tr>
                        <tr>
                            <td class="title"><a href="<?php echo esc_url(home_url('/')); ?>">Fra Offshore.no: </a></td>
                        </tr>
                    </tbody>
                </table>
    
                <div class="footer">
                    <div class="source">
                        Bilderkilder: Operatør, kontraktør, leverandører, Offshore.no, Oljedirektoratet (OD), Olje- og Energideptartement (OED) og Norsk Oljemuseum.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php get_footer(); ?>