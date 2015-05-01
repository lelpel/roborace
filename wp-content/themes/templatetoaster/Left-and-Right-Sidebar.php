<?php
/**
 * Template Name:Left-and-Right-Sidebar
 */
get_header();?>
    <div id="ttr_content_and_sidebar_container">
        <aside id="ttr_sidebar_left">
            <?php get_sidebar('1'); ?>
        </aside>
        <div id="ttr_content">
            <div id="ttr_content_margin">
                <div class="remove_collapsing_margins"></div>
                <?php if (templatetoaster_theme_option('ttr_page_breadcrumb')): ?>
                    <?php templatetoaster_wordpress_breadcrumbs(); ?>
                <?php endif; ?>
                <?php
                if (is_active_sidebar('contenttopcolumn1') || is_active_sidebar('contenttopcolumn2') || is_active_sidebar('contenttopcolumn3') || is_active_sidebar('contenttopcolumn4')):
                    ?>
                    <div class="contenttopcolumn0">
                        <?php if (is_active_sidebar('contenttopcolumn1')) : ?>
                            <div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                                <div class="topcolumn1">
                                    <?php templatetoaster_theme_dynamic_sidebar('CAWidgetArea00'); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                                &nbsp;
                            </div>
                        <?php endif; ?>
                        <div class="clearfix visible-xs-block">
                        </div>
                        <?php if (is_active_sidebar('contenttopcolumn2')) : ?>
                            <div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                                <div class="topcolumn2">
                                    <?php templatetoaster_theme_dynamic_sidebar('CAWidgetArea01'); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                                &nbsp;
                            </div>
                        <?php endif; ?>
                        <div class="clearfix visible-sm-block visible-md-block visible-xs-block">
                        </div>
                        <?php if (is_active_sidebar('contenttopcolumn3')) : ?>
                            <div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                                <div class="topcolumn3">
                                    <?php templatetoaster_theme_dynamic_sidebar('CAWidgetArea02'); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                                &nbsp;
                            </div>
                        <?php endif; ?>
                        <div class="clearfix visible-xs-block">
                        </div>
                        <?php if (is_active_sidebar('contenttopcolumn4')) : ?>
                            <div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                                <div class="topcolumn4">
                                    <?php templatetoaster_theme_dynamic_sidebar('CAWidgetArea03'); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                                &nbsp;
                            </div>
                        <?php endif; ?>
                        <div class="clearfix visible-lg-block visible-sm-block visible-md-block visible-xs-block">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                <?php endif; ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php get_template_part('content', 'page'); ?>
                    <?php comments_template('', true); ?>
                <?php endwhile; // end of the loop. ?>
                <?php
                if (is_active_sidebar('contentbottomcolumn1') || is_active_sidebar('contentbottomcolumn2') || is_active_sidebar('contentbottomcolumn3') || is_active_sidebar('contentbottomcolumn4')):
                    ?>
                    <div class="contentbottomcolumn0">
                        <?php if (is_active_sidebar('contentbottomcolumn1')) : ?>
                            <div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                                <div class="bottomcolumn1">
                                    <?php templatetoaster_theme_dynamic_sidebar('CBWidgetArea00'); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                                &nbsp;
                            </div>
                        <?php endif; ?>
                        <div class="clearfix visible-xs-block">
                        </div>
                        <?php if (is_active_sidebar('contentbottomcolumn2')) : ?>
                            <div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                                <div class="bottomcolumn2">
                                    <?php templatetoaster_theme_dynamic_sidebar('CBWidgetArea01'); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                                &nbsp;
                            </div>
                        <?php endif; ?>
                        <div class="clearfix visible-sm-block visible-md-block visible-xs-block">
                        </div>
                        <?php if (is_active_sidebar('contentbottomcolumn3')) : ?>
                            <div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                                <div class="bottomcolumn3">
                                    <?php templatetoaster_theme_dynamic_sidebar('CBWidgetArea02'); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                                &nbsp;
                            </div>
                        <?php endif; ?>
                        <div class="clearfix visible-xs-block">
                        </div>
                        <?php if (is_active_sidebar('contentbottomcolumn4')) : ?>
                            <div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                                <div class="bottomcolumn4">
                                    <?php templatetoaster_theme_dynamic_sidebar('CBWidgetArea03'); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                                &nbsp;
                            </div>
                        <?php endif; ?>
                        <div class="clearfix visible-lg-block visible-sm-block visible-md-block visible-xs-block">
                        </div>
                    </div>
                    <div class="clearfix"></div>
                <?php endif; ?>
                <div class="remove_collapsing_margins"></div>
            </div>
        </div>
        <aside id="ttr_sidebar_right">
            <?php get_sidebar('2'); ?>
        </aside>
        <div class="clearfix">
        </div>
    </div>
<?php
get_footer();
?>