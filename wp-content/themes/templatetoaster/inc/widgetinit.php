<?php
global $templatetoaster_magmenu;
global $templatetoaster_menuh;
global $templatetoaster_vmenuh;
global $templatetoaster_ocmenu;
$templatetoaster_magmenu = false;
$templatetoaster_menuh = false;
$templatetoaster_ocmenu = true;
global $templatetoaster_cssprefix;
$templatetoaster_cssprefix = "ttr_";
global $templatetoaster_skin;
$templatetoaster_skin = templatetoaster_theme_option('ttr_colorscheme');

function templatetoaster_widgets_init()
{
    global $templatetoaster_cssprefix;
    $templatetoaster_cssprefix = "ttr_";
    global $templatetoaster_theme_widget_args;
    $heading_tag = templatetoaster_theme_option('ttr_heading_tag_block');
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
    if (isset($_POST[sanitize_key('wp_customize')]) && $_POST[sanitize_key('wp_customize')] == 'on'):
        $templatetoaster_theme_widget_args = array('before_widget' => '<div class="' . $templatetoaster_cssprefix . 'block"><div class="remove_collapsing_margins"></div> <div class="' . $templatetoaster_cssprefix . 'block_header">',
            'after_widget' => '</div></div>~tt',
            'before_title' => '<h3 class="' . $templatetoaster_cssprefix . 'block_heading">',
            'after_title' => '</h3></div> <div class="' . $templatetoaster_cssprefix . 'block_content">',
        );

    else:
        $style = "";
        $Color = templatetoaster_theme_option('ttr_blockheading');
        $fontSize = templatetoaster_theme_option('ttr_font_size_block');
        if (!empty($Color) && $Color != "#") {
            $style .= "color:" . $Color . "; ";
        }
        if (!empty($fontSize)) {
            $style .= "font-size:" . $fontSize . "px;";
        }
        if (!empty($style)) {
            $templatetoaster_theme_widget_args = array('before_widget' => '<div class="' . $templatetoaster_cssprefix . 'block"><div class="remove_collapsing_margins"></div> <div class="' . $templatetoaster_cssprefix . 'block_header">',
                'after_widget' => '</div></div>~tt',
                'before_title' => '<' . $heading_tag . ' style="' . $style . '" class="' . $templatetoaster_cssprefix . 'block_heading">
',
                'after_title' => '</' . $heading_tag . '></div> <div class="' . $templatetoaster_cssprefix . 'block_content">',
            );
        } else {
            $templatetoaster_theme_widget_args = array('before_widget' => '<div class="' . $templatetoaster_cssprefix . 'block"><<div class="remove_collapsing_margins"></div> <div class="' . $templatetoaster_cssprefix . 'block_header">',
                'after_widget' => '</div></div>~tt',
                'before_title' => '<' . $heading_tag . ' class="' . $templatetoaster_cssprefix . 'block_heading">
',
                'after_title' => '</' . $heading_tag . '></div> <div class="' . $templatetoaster_cssprefix . 'block_content">',
            );
        }

    endif;
    extract($templatetoaster_theme_widget_args);
    register_sidebar(array(
        'name' => __('Left Sidebar', CURRENT_THEME),
        'id' => 'sidebar-1',
        'description' => __('The sidebar for the optional Showcase Template', CURRENT_THEME),
        'before_widget' => $before_widget,
        'after_widget' => $after_widget,
        'before_title' => $before_title,
        'after_title' => $after_title,
    ));
    register_sidebar(array(
        'name' => __('Right Sidebar', CURRENT_THEME),
        'id' => 'sidebar-2',
        'description' => __('The sidebar for the optional Showcase Template', CURRENT_THEME),
        'before_widget' => $before_widget,
        'after_widget' => $after_widget,
        'before_title' => $before_title,
        'after_title' => $after_title,
    ));
    register_sidebar(array(
        'name' => __('Content Above Widget 1', CURRENT_THEME),
        'id' => 'contenttopcolumn1',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Content Above Widget 2', CURRENT_THEME),
        'id' => 'contenttopcolumn2',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Content Above Widget 3', CURRENT_THEME),
        'id' => 'contenttopcolumn3',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Content Above Widget 4', CURRENT_THEME),
        'id' => 'contenttopcolumn4',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Header Position1', CURRENT_THEME),
        'id' => 'headerposition1',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Header Above Widget 1', CURRENT_THEME),
        'id' => 'headerabovecolumn1',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Header Above Widget 2', CURRENT_THEME),
        'id' => 'headerabovecolumn2',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Header Above Widget 3', CURRENT_THEME),
        'id' => 'headerabovecolumn3',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Header Above Widget 4', CURRENT_THEME),
        'id' => 'headerabovecolumn4',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Header Below Widget 1', CURRENT_THEME),
        'id' => 'headerbelowcolumn1',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Header Below Widget 2', CURRENT_THEME),
        'id' => 'headerbelowcolumn2',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Header Below Widget 3', CURRENT_THEME),
        'id' => 'headerbelowcolumn3',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Header Below Widget 4', CURRENT_THEME),
        'id' => 'headerbelowcolumn4',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Menu Above Widget 1', CURRENT_THEME),
        'id' => 'menuabovecolumn1',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Menu Above Widget 2', CURRENT_THEME),
        'id' => 'menuabovecolumn2',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Menu Above Widget 3', CURRENT_THEME),
        'id' => 'menuabovecolumn3',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Menu Above Widget 4', CURRENT_THEME),
        'id' => 'menuabovecolumn4',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Menu Below Widget 1', CURRENT_THEME),
        'id' => 'menubelowcolumn1',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Menu Below Widget 2', CURRENT_THEME),
        'id' => 'menubelowcolumn2',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Menu Below Widget 3', CURRENT_THEME),
        'id' => 'menubelowcolumn3',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Menu Below Widget 4', CURRENT_THEME),
        'id' => 'menubelowcolumn4',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Content Below Widget 1', CURRENT_THEME),
        'id' => 'contentbottomcolumn1',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Content Below Widget 2', CURRENT_THEME),
        'id' => 'contentbottomcolumn2',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Content Below Widget 3', CURRENT_THEME),
        'id' => 'contentbottomcolumn3',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Content Below Widget 4', CURRENT_THEME),
        'id' => 'contentbottomcolumn4',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Footer Position1', CURRENT_THEME),
        'id' => 'footerposition1',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Footer Above Widget 1', CURRENT_THEME),
        'id' => 'footerabovecolumn1',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Footer Above Widget 2', CURRENT_THEME),
        'id' => 'footerabovecolumn2',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Footer Above Widget 3', CURRENT_THEME),
        'id' => 'footerabovecolumn3',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Footer Above Widget 4', CURRENT_THEME),
        'id' => 'footerabovecolumn4',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Footer Below Widget 1', CURRENT_THEME),
        'id' => 'footerbelowcolumn1',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Footer Below Widget 2', CURRENT_THEME),
        'id' => 'footerbelowcolumn2',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Footer Below Widget 3', CURRENT_THEME),
        'id' => 'footerbelowcolumn3',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('Footer Below Widget 4', CURRENT_THEME),
        'id' => 'footerbelowcolumn4',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('first-footer-widget-area', CURRENT_THEME),
        'id' => 'first-footer-widget-area',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('second-footer-widget-area', CURRENT_THEME),
        'id' => 'second-footer-widget-area',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    register_sidebar(array(
        'name' => __('third-footer-widget-area', CURRENT_THEME),
        'id' => 'third-footer-widget-area',
        'description' => __('An optional widget area for your site footer', CURRENT_THEME),
        'before_widget' => '<aside class="widget %2$s">',
        'after_widget' => "</aside>~tt",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
}

add_action('widgets_init', 'templatetoaster_widgets_init');?>