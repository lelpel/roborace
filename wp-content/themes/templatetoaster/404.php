<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package templatetoaster
 */

if (templatetoaster_theme_option('ttr_error_home_redirect')):
    header('Location:' . home_url());
endif;
get_header(); ?>
<div id="ttr_content_and_sidebar_container">
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
                                <?php templatetoaster_theme_dynamic_sidebar('Content Above Widget 1'); ?>
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
                                <?php templatetoaster_theme_dynamic_sidebar('Content Above Widget 2'); ?>
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
                                <?php templatetoaster_theme_dynamic_sidebar('Content Above Widget 3'); ?>
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
                                <?php templatetoaster_theme_dynamic_sidebar('Content Above Widget 4'); ?>
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
            <?php if (templatetoaster_theme_option('ttr_error_message')): ?>
            <h1><?php echo templatetoaster_theme_option('ttr_error_message_heading'); ?></h1>

            <div class="postcontent">
                <p><?php echo templatetoaster_theme_option('ttr_error_message_content'); ?></p>
                <?php endif; ?>
                <?php if (templatetoaster_theme_option('ttr_error_search_box')): ?>
                    <?php get_search_form(); ?>
                    <br/><br/>
                <?php endif; ?>
                <?php if (templatetoaster_theme_option('ttr_error_image_enable')): ?>
                    <div>
                        <?php $templatetoaster_skin = templatetoaster_theme_option('ttr_colorscheme');
                        if ($templatetoaster_skin == 'choice1')
                            $templatetoaster_skin == 'Default';
                        elseif ($templatetoaster_skin == 'choice2')
                            $templatetoaster_skin == 'Red';
                        elseif ($templatetoaster_skin == 'choice3')
                            $templatetoaster_skin == 'Skyblue';
                        elseif ($templatetoaster_skin == 'choice4')
                            $templatetoaster_skin == 'Pink';
                        elseif ($templatetoaster_skin == 'choice5')
                            $templatetoaster_skin == 'SeaGreen';
                        elseif ($templatetoaster_skin == 'choice6')
                            $templatetoaster_skin == 'Green';
                        ?>
                        <input type="image"
                               height="<?php echo esc_attr(templatetoaster_theme_option('ttr_error_image_height')); ?>px"
                               width="<?php echo esc_attr(templatetoaster_theme_option('ttr_error_image_width')); ?>px"
                               alt="<?php esc_attr_e('Error Image', CURRENT_THEME); ?>"
                               src="<?php if (templatetoaster_theme_option('ttr_error_image')): echo esc_url(templatetoaster_theme_option('ttr_error_image'));
                               else:$gotopng = get_template_directory_uri() . '/images/' . $templatetoaster_skin . '/gototop.png';
                                   echo esc_url($gotopng); endif; ?>"/>
                    </div>
                <?php endif; ?>
                <?php the_widget('WP_Widget_Recent_Posts', array('number' => 10), array('widget_id' => '404')); ?>
                <div class="widget">
                    <br/>

                    <h2><?php _e('Most Used Categories', CURRENT_THEME); ?></h2>
                    <ul>
                        <?php wp_list_categories(array('orderby' => 'count', 'order' => 'DESC', 'show_count' => 1, 'title_li' => '', 'number' => 10)); ?>
                    </ul>
                    <br/>
                </div>
                <?php
                $archive_content = '<p>' . sprintf(__('Try looking in the monthly archives.', CURRENT_THEME) . "%s", convert_smilies(':)')) . '</p>';
                the_widget('WP_Widget_Archives', array('count' => 0, 'dropdown' => 1), array('after_title' => '</h2>' . $archive_content));
                ?>
                <br/>
                <?php the_widget('WP_Widget_Tag_Cloud'); ?>
                <div class="clearfix"></div>
            </div>
            <?php
            if (is_active_sidebar('contentbottomcolumn1') || is_active_sidebar('contentbottomcolumn2') || is_active_sidebar('contentbottomcolumn3') || is_active_sidebar('contentbottomcolumn4')):
                ?>
                <div class="contentbottomcolumn0">
                    <?php if (is_active_sidebar('contentbottomcolumn1')) : ?>
                        <div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                            <div class="bottomcolumn1">
                                <?php templatetoaster_theme_dynamic_sidebar('Content Below Widget 1'); ?>
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
                                <?php templatetoaster_theme_dynamic_sidebar('Content Below Widget 2'); ?>
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
                                <?php templatetoaster_theme_dynamic_sidebar('Content Below Widget 3'); ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                            &nbsp;
                        </div>
                    <?php endif; ?>
                    <?php if (is_active_sidebar('contentbottomcolumn4')) : ?>
                        <div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                            <div class="bottomcolumn4">
                                <?php templatetoaster_theme_dynamic_sidebar('Content Below Widget 4'); ?>
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
    <div class="clearfix">
    </div>
</div>
<?php get_footer(); ?>
