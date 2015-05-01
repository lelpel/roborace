<?php
/**
 * The template for displaying the footer.
 *
 * @package templatetoaster
 */

$theme_path = get_template_directory_uri(); ?>
<div class="footer-widget-area" role="complementary">
    <div class="footer-widget-area_inner">
        <?php
        if (is_active_sidebar('footerabovecolumn1') || is_active_sidebar('footerabovecolumn2') || is_active_sidebar('footerabovecolumn3') || is_active_sidebar('footerabovecolumn4')):
            ?>
            <div class="ttr_footer-widget-area_inner_above0">
                <?php if (is_active_sidebar('footerabovecolumn1')) : ?>
                    <div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                        <div class="footerabovecolumn1">
                            <?php templatetoaster_theme_dynamic_sidebar('Footer Above Widget 1'); ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                        &nbsp;
                    </div>
                <?php endif; ?>
                <div class="clearfix visible-xs-block">
                </div>
                <?php if (is_active_sidebar('footerabovecolumn2')) : ?>
                    <div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                        <div class="footerabovecolumn2">
                            <?php templatetoaster_theme_dynamic_sidebar('Footer Above Widget 2'); ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                        &nbsp;
                    </div>
                <?php endif; ?>
                <div class="clearfix visible-sm-block visible-md-block visible-xs-block">
                </div>
                <?php if (is_active_sidebar('footerabovecolumn3')) : ?>
                    <div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                        <div class="footerabovecolumn3">
                            <?php templatetoaster_theme_dynamic_sidebar('Footer Above Widget 3'); ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                        &nbsp;
                    </div>
                <?php endif; ?>
                <div class="clearfix visible-xs-block">
                </div>
                <?php if (is_active_sidebar('footerabovecolumn4')) : ?>
                    <div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                        <div class="footerabovecolumn4">
                            <?php templatetoaster_theme_dynamic_sidebar('Footer Above Widget 4'); ?>
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
    </div>
</div>
<div class="remove_collapsing_margins"></div>
<!--<?php $var = "true";
if (isset($post)) {
    $var = get_post_meta($post->ID, 'ttr_page_foot_checkbox', true);
}
if ($var == "true" || $var == ""):?>-->
    <footer id="ttr_footer">
        <div id="ttr_footer_top_for_widgets">
            <div class="ttr_footer_top_for_widgets_inner">
                <?php get_sidebar('footer'); ?>
            </div>
        </div>
        <div class="ttr_footer_bottom_footer">
            <div class="ttr_footer_bottom_footer_inner">
                <?php $total_widgets = wp_get_sidebars_widgets();
                $sidebar_widgets = count($total_widgets['footerposition1']);
                if ($sidebar_widgets) : ?>
                    <div class=footerposition1>
                        <?php templatetoaster_theme_dynamic_sidebar('footerposition1'); ?>
                    </div>
                <?php endif; ?>
                <div id="ttr_footer_content">
                    <!--Copyright-->
                    <?php
                    if (isset($_POST[sanitize_key('wp_customize')]) && $_POST[sanitize_key('wp_customize')] == 'on'):?>

                        <a href="<?php $copyright_url = home_url();
                        echo esc_url($copyright_url); ?>">
                            <?php $copyright_text = "&copy; 2014";
                            echo esc_url($copyright_text);
                            ?>
                        </a>
                    <?php else: ?>
                        <?php if (templatetoaster_theme_option('ttr_copyright_disable')): ?>
                            <?php $copyright_url = templatetoaster_theme_option('ttr_copyright_url');
                            if (!empty($copyright_url)):?>
                                <?php $style = "";
                                $Color = templatetoaster_theme_option('ttr_copyright');
                                $fontSize = templatetoaster_theme_option('ttr_font_size_copyright');
                                if (!empty($Color) && $Color != "#") {
                                    $style .= "color:" . $Color . "; ";
                                }
                                if (!empty($fontSize)) {
                                    $style .= "font-size:" . $fontSize . "px;";
                                }
                                ?>
                                <a <?php if (!empty($style)) {
                                    echo 'style="' . $style . '"';
                                } ?>
                                    href="<?php echo esc_url($copyright_url); ?>">
                                    <?php if (templatetoaster_theme_option('ttr_copyright_text')):
                                        $copyright_text = templatetoaster_theme_option('ttr_copyright_text');
                                        echo $copyright_text;
                                    endif;
                                    ?>
                                </a>
                            <?php else: ?>
                                <?php $style = "";
                                $Color = templatetoaster_theme_option('ttr_copyright');
                                $fontSize = templatetoaster_theme_option('ttr_font_size_copyright');
                                if (!empty($Color) && $Color != "#") {
                                    $style .= "color:" . $Color . "; ";
                                }
                                if (!empty($fontSize)) {
                                    $style .= "font-size:" . $fontSize . "px;";
                                }
                                ?>
                                <span <?php if (!empty($style)) {
                                    echo 'style="' . $style . '"';
                                } ?>>
							
							<?php if (templatetoaster_theme_option('ttr_copyright_text')):
                                $copyright_text = templatetoaster_theme_option('ttr_copyright_text');
                                echo $copyright_text;
                            endif;
                            ?>
							</span>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>

                    <!--Designed By-->
                    <?php
                    if (isset($_POST[sanitize_key('wp_customize')]) && $_POST[sanitize_key('wp_customize')] == 'on'):
                        $url_copyright = "http://templatetoaster.com";?>
                        <?php $style = "";
                        $Color = templatetoaster_theme_option('ttr_designedbylink');
                        $fontSize = templatetoaster_theme_option('ttr_font_size_designedbylink');
                        if (!empty($Color) && $Color != "#") {
                            $style .= "color:" . $Color . "; ";
                        }
                        if (!empty($fontSize)) {
                            $style .= "font-size:" . $fontSize . "px;";
                        }
                        ?>
                        <a <?php if (!empty($style)) {
                            echo 'style="' . $style . '"';
                        } ?>
                            href= <?php esc_url($url_copyright); ?>>
                            <?php echo(__('Wordpress Theme', CURRENT_THEME)); ?>
                        </a>

                        <?php $style = "";
                        $Color = templatetoaster_theme_option('ttr_designedby');
                        $fontSize = templatetoaster_theme_option('ttr_font_size_designedby');
                        if (!empty($Color) && $Color != "#") {
                            $style .= "color:" . $Color . "; ";
                        }
                        if (!empty($fontSize)) {
                            $style .= "font-size:" . $fontSize . "px;";
                        }
                        ?>
                        <span <?php if (!empty($style)) {
                            echo 'style="' . $style . '"';
                        } ?>>
							<?php echo(__('Designed With TemplateToaster', CURRENT_THEME)); ?>
							</span>
                    <?php else: ?>
                        <?php $style = "";
                        $Color = templatetoaster_theme_option('ttr_designedbylink');
                        $fontSize = templatetoaster_theme_option('ttr_font_size_designedbylink');
                        if (!empty($Color) && $Color != "#") {
                            $style .= "color:" . $Color . "; ";
                        }
                        if (!empty($fontSize)) {
                            $style .= "font-size:" . $fontSize . "px;";
                        }
                        ?>
                        <a <?php if (!empty($style)) {
                            echo 'style="' . $style . '"';
                        } ?>
                            href="http://templatetoaster.com">
                            <?php echo(__('Wordpress Theme', CURRENT_THEME)); ?>
                        </a>
                        <?php $style = "";
                        $Color = templatetoaster_theme_option('ttr_designedby');
                        $fontSize = templatetoaster_theme_option('ttr_font_size_designedby');
                        if (!empty($Color) && $Color != "#") {
                            $style .= "color:" . $Color . "; ";
                        }
                        if (!empty($fontSize)) {
                            $style .= "font-size:" . $fontSize . "px;";
                        }
                        ?>
                        <span <?php if (!empty($style)) {
                            echo 'style="' . $style . '"';
                        } ?>>
							<?php echo(__('Designed With TemplateToaster', CURRENT_THEME)); ?>
							</span>
                    <?php endif; ?>
                    <!--Powered By-->
                    <a href="http://wordpress.org/"><?php echo(__('Proudly powered by WordPress', CURRENT_THEME)); ?></a>
                </div>
            </div>
        </div>
    </footer>
<!--<?php endif; ?>-->
<div class="remove_collapsing_margins"></div>
<div class="footer-widget-area" role="complementary">
    <div class="footer-widget-area_inner">
        <?php
        if (is_active_sidebar('footerbelowcolumn1') || is_active_sidebar('footerbelowcolumn2') || is_active_sidebar('footerbelowcolumn3') || is_active_sidebar('footerbelowcolumn4')):
            ?>
            <div class="ttr_footer-widget-area_inner_below0">
                <?php if (is_active_sidebar('footerbelowcolumn1')) : ?>
                    <div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                        <div class="footerbelowcolumn1">
                            <?php templatetoaster_theme_dynamic_sidebar('Footer Below Widget 1'); ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                        &nbsp;
                    </div>
                <?php endif; ?>
                <div class="clearfix visible-xs-block">
                </div>
                <?php if (is_active_sidebar('footerbelowcolumn2')) : ?>
                    <div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                        <div class="footerbelowcolumn2">
                            <?php templatetoaster_theme_dynamic_sidebar('Footer Below Widget 2'); ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                        &nbsp;
                    </div>
                <?php endif; ?>
                <div class="clearfix visible-sm-block visible-md-block visible-xs-block">
                </div>
                <?php if (is_active_sidebar('footerbelowcolumn3')) : ?>
                    <div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                        <div class="footerbelowcolumn3">
                            <?php templatetoaster_theme_dynamic_sidebar('Footer Below Widget 3'); ?>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                        &nbsp;
                    </div>
                <?php endif; ?>
                <div class="clearfix visible-xs-block">
                </div>
                <?php if (is_active_sidebar('footerbelowcolumn4')) : ?>
                    <div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                        <div class="footerbelowcolumn4">
                            <?php templatetoaster_theme_dynamic_sidebar('Footer Below Widget 4'); ?>
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
    </div>
</div>
</div>
<?php wp_footer(); ?>
</body>
</html>
