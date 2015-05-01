<?php
/**
 * The header for our theme.
 *
 * @package templatetoaster
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<?php $body_class = get_page_template_slug(); ?>
<body <?php body_class(rtrim(get_page_template_slug(), ".php")); ?>>
<?php if (isset($_POST[sanitize_key('wp_customize')]) && $_POST[sanitize_key('wp_customize')] == 'on'):
    $gotopng = get_template_directory_uri() . '/images/Default/gototop.png';?>
    <a href="#" class="back-to-top"><img alt="<?php esc_attr_e('Back to Top', CURRENT_THEME); ?>"
                                         src="<?php echo esc_url($gotopng); ?>"/></a>
<?php
else:
    $gotopng = templatetoaster_theme_option('ttr_icon_back_to_top');?>
    <?php if (templatetoaster_theme_option('ttr_back_to_top')): ?>
    <a href="#" class="back-to-top"><img alt="<?php esc_attr_e('Back to Top', CURRENT_THEME); ?>"
                                         src="<?php echo esc_url($gotopng); ?>"/></a>
<?php endif; ?>
<?php endif; ?>
<div id="ttr_page" class="container">
<div class="ttr_banner_menu">
    <?php
    if (is_active_sidebar('menuabovecolumn1') || is_active_sidebar('menuabovecolumn2') || is_active_sidebar('menuabovecolumn3') || is_active_sidebar('menuabovecolumn4')):
        ?>
        <div class="ttr_banner_menu_inner_above0">
            <?php if (is_active_sidebar('menuabovecolumn1')) : ?>
                <div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                    <div class="menuabovecolumn1">
                        <?php templatetoaster_theme_dynamic_sidebar('Menu Above Widget 1'); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                    &nbsp;
                </div>
            <?php endif; ?>
            <div class="clearfix visible-xs-block">
            </div>
            <?php if (is_active_sidebar('menuabovecolumn2')) : ?>
                <div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                    <div class="menuabovecolumn2">
                        <?php templatetoaster_theme_dynamic_sidebar('Menu Above Widget 2'); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                    &nbsp;
                </div>
            <?php endif; ?>
            <div class="clearfix visible-sm-block visible-md-block visible-xs-block">
            </div>
            <?php if (is_active_sidebar('menuabovecolumn3')) : ?>
                <div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                    <div class="menuabovecolumn3">
                        <?php templatetoaster_theme_dynamic_sidebar('Menu Above Widget 3'); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                    &nbsp;
                </div>
            <?php endif; ?>
            <div class="clearfix visible-xs-block">
            </div>
            <?php if (is_active_sidebar('menuabovecolumn4')) : ?>
                <div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                    <div class="menuabovecolumn4">
                        <?php templatetoaster_theme_dynamic_sidebar('Menu Above Widget 4'); ?>
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
<div class="remove_collapsing_margins"></div>
<nav id="ttr_menu" class="navbar-default navbar">
    <div id="ttr_menu_inner_in">
        <div class="menuforeground">
        </div>
        <div id="navigationmenu">
            <div class="navbar-header">
                <button id="nav-expander" data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle"
                        type="button">
<span class="sr-only">
</span>
<span class="icon-bar">
</span>
<span class="icon-bar">
</span>
<span class="icon-bar">
</span>
                </button>
                <?php

                if (isset($_POST[sanitize_key('wp_customize')]) && $_POST[sanitize_key('wp_customize')] == 'on'):
                    $menulogo = get_template_directory_uri() . '/menulogo.png';
                    ?>
                    <a class="navbar-brand" href="#">
                        <img class="ttr_menu_logo" src="<?php echo esc_url($menulogo); ?>"
                             alt="<?php esc_attr_e("Menulogo", CURRENT_THEME); ?>"/></a>
                <?php else: ?>
                    <?php if (templatetoaster_theme_option('ttr_menu_logo_enable')): ?>
                        <a class="navbar-brand" href="#">
                            <img class="ttr_menu_logo"
                                 src="<?php echo esc_url(templatetoaster_theme_option('ttr_logo')); ?>"
                                 alt="<?php esc_attr_e("Menulogo", CURRENT_THEME); ?>"/></a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <div class="menu-center collapse navbar-collapse">
                <ul class="ttr_menu_items nav navbar-nav navbar-right">
                    <?php echo templatetoaster_theme_nav_menu('ttr_', 'primary', 'menu', False, False, False, True); ?>
                </ul>
            </div>
        </div>
    </div>
</nav>
<div class="ttr_banner_menu">
    <?php
    if (is_active_sidebar('menubelowcolumn1') || is_active_sidebar('menubelowcolumn2') || is_active_sidebar('menubelowcolumn3') || is_active_sidebar('menubelowcolumn4')):
        ?>
        <div class="ttr_banner_menu_inner_below0">
            <?php if (is_active_sidebar('menubelowcolumn1')) : ?>
                <div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                    <div class="menubelowcolumn1">
                        <?php templatetoaster_theme_dynamic_sidebar('Menu Below Widget 1'); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                    &nbsp;
                </div>
            <?php endif; ?>
            <div class="clearfix visible-xs-block">
            </div>
            <?php if (is_active_sidebar('menubelowcolumn2')) : ?>
                <div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                    <div class="menubelowcolumn2">
                        <?php templatetoaster_theme_dynamic_sidebar('Menu Below Widget 2'); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                    &nbsp;
                </div>
            <?php endif; ?>
            <div class="clearfix visible-sm-block visible-md-block visible-xs-block">
            </div>
            <?php if (is_active_sidebar('menubelowcolumn3')) : ?>
                <div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                    <div class="menubelowcolumn3">
                        <?php templatetoaster_theme_dynamic_sidebar('Menu Below Widget 3'); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                    &nbsp;
                </div>
            <?php endif; ?>
            <div class="clearfix visible-xs-block">
            </div>
            <?php if (is_active_sidebar('menubelowcolumn4')) : ?>
                <div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                    <div class="menubelowcolumn4">
                        <?php templatetoaster_theme_dynamic_sidebar('Menu Below Widget 4'); ?>
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
<div class="ttr_banner_header">
    <?php
    if (is_active_sidebar('headerabovecolumn1') || is_active_sidebar('headerabovecolumn2') || is_active_sidebar('headerabovecolumn3') || is_active_sidebar('headerabovecolumn4')):
        ?>
        <div class="ttr_banner_header_inner_above0">
            <?php if (is_active_sidebar('headerabovecolumn1')) : ?>
                <div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                    <div class="headerabovecolumn1">
                        <?php templatetoaster_theme_dynamic_sidebar('Header Above Widget 1'); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                    &nbsp;
                </div>
            <?php endif; ?>
            <div class="clearfix visible-xs-block"></div>
            <?php if (is_active_sidebar('headerabovecolumn2')) : ?>
                <div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                    <div class="headerabovecolumn2">
                        <?php templatetoaster_theme_dynamic_sidebar('Header Above Widget 2'); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                    &nbsp;
                </div>
            <?php endif; ?>
            <div class="clearfix visible-sm-block visible-md-block visible-xs-block">
            </div>
            <?php if (is_active_sidebar('headerabovecolumn3')) : ?>
                <div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                    <div class="headerabovecolumn3">
                        <?php templatetoaster_theme_dynamic_sidebar('Header Above Widget 3'); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                    &nbsp;
                </div>
            <?php endif; ?>
            <div class="clearfix visible-xs-block">
            </div>
            <?php if (is_active_sidebar('headerabovecolumn4')) : ?>
                <div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                    <div class="headerabovecolumn4">
                        <?php templatetoaster_theme_dynamic_sidebar('Header Above Widget 4'); ?>
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
<div class="remove_collapsing_margins"></div>
<header id="ttr_header">
    <div id="ttr_header_inner">
        <?php
        if (isset($_POST[sanitize_key('wp_customize')]) && $_POST[sanitize_key('wp_customize')] == 'on'):?>
        <div class="ttr_title_position">
            <?php
            $heading_tag = 'h1';
            ?>
            <<?php echo $heading_tag; ?> class="ttr_title_style"> <?php
            $style = "";
            $titleColor = templatetoaster_theme_option('ttr_title');
            $fontSize = templatetoaster_theme_option('ttr_font_size_title');
            if (!empty($titleColor) && $titleColor != "#") {
                $style .= "color:" . $titleColor . "; ";
            }
            if (!empty($fontSize)) {
                $style .= "font-size:" . $fontSize . "px;";
            }
            ?>
            <a <?php if (!empty($style)) {
                echo 'style="' . $style . '"';
            } ?> href="<?php echo esc_url(home_url('/')); ?>"
                 title="<?php esc_attr_e(get_bloginfo('name', CURRENT_THEME)); ?>"
                 rel="home"><?php bloginfo('name'); ?></a>
        </<?php echo $heading_tag; ?>>
    </div>
    <?php else: ?>
    <?php if (templatetoaster_theme_option('ttr_site_title_enable')): ?>
    <div class="ttr_title_position">
        <?php
        $heading_tag = templatetoaster_theme_option('ttr_heading_tag_title');
        if ($heading_tag == 'choice1')
            $heading_tag = 'h1';
        elseif ($heading_tag == 'choice2')
            $heading_tag = 'h2';
        elseif ($heading_tag == 'choice3')
            $heading_tag = 'h3';
        elseif ($heading_tag == 'choice4')
            $heading_tag = 'h4';
        elseif ($heading_tag == 'choice5')
            $heading_tag = 'h5';
        elseif ($heading_tag == 'choice6')
            $heading_tag = 'h6';
        ?>
        <<?php echo $heading_tag; ?> class="ttr_title_style">
        <?php $style = "";
        $titleColor = templatetoaster_theme_option('ttr_title');
        $fontSize = templatetoaster_theme_option('ttr_font_size_title');
        if (!empty($titleColor) && $titleColor != "#") {
            $style .= "color:" . $titleColor . "; ";
        }
        if (!empty($fontSize)) {
            $style .= "font-size:" . $fontSize . "px;";
        }
        ?>
        <a <?php if (!empty($style)) {
            echo 'style="' . $style . '"';
        } ?>
            href="<?php echo esc_url(home_url('/')); ?>"
            title="<?php esc_attr_e(get_bloginfo('name', CURRENT_THEME)); ?>"
            rel="home"><?php form_option('blogname'); ?></a>
    </<?php echo $heading_tag; ?>>
</div>
<?php endif; ?>
<?php endif; ?>
<?php if (isset($_POST[sanitize_key('wp_customize')]) && $_POST[sanitize_key('wp_customize')] == 'on'): ?>
    <div class="ttr_slogan_position">
    <?php
    $slogan_tag = 'h2';
    ?>
    <<?php echo $slogan_tag; ?> class="ttr_slogan_style">
    <?php bloginfo('description'); ?>
    </<?php echo $slogan_tag; ?>>
    </div>
<?php else: ?>
    <?php if (templatetoaster_theme_option('ttr_site_slogan_enable')): ?>
        <div class="ttr_slogan_position">
        <?php
        $slogan_tag = templatetoaster_theme_option('ttr_heading_tag_slogan');

        if ($slogan_tag == 'choice1')
            $slogan_tag = 'h1';
        elseif ($slogan_tag == 'choice2')
            $slogan_tag = 'h2';
        elseif ($slogan_tag == 'choice3')
            $slogan_tag = 'h3';
        elseif ($slogan_tag == 'choice4')
            $slogan_tag = 'h4';
        elseif ($slogan_tag == 'choice5')
            $slogan_tag = 'h5';
        elseif ($slogan_tag == 'choice6')
            $slogan_tag = 'h6';

        $style = "";
        $sloganColor = templatetoaster_theme_option('ttr_slogan');
        $sloganfontSize = templatetoaster_theme_option('ttr_font_size_slogan');
        if (!empty($sloganColor) && $sloganColor != "#") {
            $style .= "color:" . $sloganColor . "; ";
        }
        if (!empty($sloganfontSize)) {
            $style .= "font-size:" . $sloganfontSize . "px;";
        }
        ?>
        <<?php echo $slogan_tag;?><?php  if (!empty($style)) {
            echo ' style="' . $style . '"';
        } ?> class="ttr_slogan_style">
        <?php form_option('blogdescription'); ?>
        </<?php echo $slogan_tag; ?>>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php $total_widgets = wp_get_sidebars_widgets();
$sidebar_widgets = count($total_widgets['headerposition1']);
if ($sidebar_widgets) : ?>
    <div class=headerposition1>
        <?php templatetoaster_theme_dynamic_sidebar('headerposition1'); ?>
    </div>
<?php endif; ?>
</div>
</header>

<div class="ttr_banner_header">
    <?php
    if (is_active_sidebar('headerbelowcolumn1') || is_active_sidebar('headerbelowcolumn2') || is_active_sidebar('headerbelowcolumn3') || is_active_sidebar('headerbelowcolumn4')):
        ?>
        <div class="ttr_banner_header_inner_below0">
            <?php if (is_active_sidebar('headerbelowcolumn1')) : ?>
                <div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                    <div class="headerbelowcolumn1">
                        <?php templatetoaster_theme_dynamic_sidebar('Header Below Widget 1'); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="cell1 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                    &nbsp;
                </div>
            <?php endif; ?>
            <div class="clearfix visible-xs-block">
            </div>
            <?php if (is_active_sidebar('headerbelowcolumn2')) : ?>
                <div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                    <div class="headerbelowcolumn2">
                        <?php templatetoaster_theme_dynamic_sidebar('Header Below Widget 2'); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="cell2 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                    &nbsp;
                </div>
            <?php endif; ?>
            <div class="clearfix visible-sm-block visible-md-block visible-xs-block">
            </div>
            <?php if (is_active_sidebar('headerbelowcolumn3')) : ?>
                <div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                    <div class="headerbelowcolumn3">
                        <?php templatetoaster_theme_dynamic_sidebar('Header Below Widget 3'); ?>
                    </div>
                </div>
            <?php else: ?>
                <div class="cell3 col-lg-3 col-md-6 col-sm-6  col-xs-12 transparent">
                    &nbsp;
                </div>
            <?php endif; ?>
            <div class="clearfix visible-xs-block">
            </div>
            <?php if (is_active_sidebar('headerbelowcolumn4')) : ?>
                <div class="cell4 col-lg-3 col-md-6 col-sm-6  col-xs-12">
                    <div class="headerbelowcolumn4">
                        <?php templatetoaster_theme_dynamic_sidebar('Header Below Widget 4'); ?>
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

