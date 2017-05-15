<?php get_header() ?>

    <div class="container">
        <div class="row">
            <div class="col-sm-9 col-lg-7">
                <?php if (isset($_GET['action']) && $_GET['action'] == 'add') : ?>
                    <div class="row nytt-om-navn">
                        <h3 class="col-xs-12">Nyansatt eller ny ansatt? Presenter det for  bransjen</h3>
                        <form role="fu-upload-form" id="names_add_new_form" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="action" value="names-add-new" />
                            <input type="hidden" name="redirect_url" value="<?php echo home_url('/offshore/names') ?>" />
                            <?php wp_nonce_field( 'names-add-new' ); ?>
                            <div class="col-xs-6 col-sm-7 block-upload-form">
                                <div>
                                    <label>Navn (alder)</label>
                                    <input type="text" name="name" required />
                                </div>
                                <div>
                                    <label>Ny arbeidsgiver</label>
                                    <input type="text" name="employer" required />
                                </div>
                                <div>
                                    <label>E-post</label>
                                    <input type="email" name="email" required />
                                </div>
                                <div>
                                    <label>Informasjonstekst</label>
                                    <textarea name="excerpt" rows="5" required></textarea>
                                </div>

                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-3 avatar-upload">
                                <img id="avatar-img" class="img-responsive" alt="your image" src="<?php module_img('names/no-avatar.png') ?>"/>
                                <label class="fileInput">
                                    <span>Last opp profilbilde</span>
                                    <input type="file" name="avatar" id="user-avatar" required/>
                                </label>
                                <div id="no-file" class="invisible">Velg en fil å laste opp</div>
                            </div>
                            <div class="col-xs-12 send-button">
                                <input type="submit" value="Legg ut din melding"/>
                            </div>
                        </form>
                    </div>
                <?php else: ?>
                    <div class="new-appointment-pop-up hidden">
                        <h2>Takk for din melding</h2>
                        Etter endelig godkjenning, vil din melding presenteres på denne siden.
                    </div>
                    <a href="?action=add">Add new</a>

                    <div class="names-list">
                    <?php
                    $query = new WP_Query(array(
                        'post_type' => 'name'
                    ));
                    while ($query->have_posts()):
                        $query->the_post();
                        ?>
                        <div class="well well-sm clearfix name-item">
                            <?php the_post_thumbnail('thumbnail', array('class' => 'pull-left img-responsive')); ?>
                            <h3><?php the_title() ?></h3>
                            <h5><?php echo get_post_field('employer', get_the_ID()); ?></h5>
                            <?php the_excerpt() ?>
                        </div>
                    <?php endwhile; ?>
                    </div>

                <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php get_footer() ?>