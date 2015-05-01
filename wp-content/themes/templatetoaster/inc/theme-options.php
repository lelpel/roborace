<?php

/*
 * TemplateToaster Theme Options
 */

class Templatetoaster_Theme_Options
{

    private $sections;
    private $checkboxes;
    private $settings;

    /**
     * Construct
     *
     * @since 1.0
     */
    public function __construct()
    {

        // This will keep track of the checkbox options for the validate_settings function.
        $this->checkboxes = array();
        $this->settings = array();
        $this->get_options();
        $this->sections['colorscheme'] = __('Color Scheme', CURRENT_THEME);
        $this->sections['header'] = __('Header', CURRENT_THEME);
        $this->sections['menuoptions'] = __('Menu', CURRENT_THEME);
        $this->sections['postcontent'] = __('Post / Content', CURRENT_THEME);
        $this->sections['sidebar'] = __('Sidebar', CURRENT_THEME);
        $this->sections['footer'] = __('Footer', CURRENT_THEME);
        $this->sections['colors'] = __('Colors', CURRENT_THEME);
        $this->sections['generaloptions'] = __('General', CURRENT_THEME);
        $this->sections['error'] = __('Error Page', CURRENT_THEME);

        add_action('admin_menu', array(&$this, 'add_pages'));
        add_action('admin_init', array(&$this, 'register_settings'));

        if (!get_option('templatetoaster_theme_options')) {
            $this->initialize_settings();
        }
    }

    /**
     * Add options page
     *
     * @since 1.0
     */
    public function add_pages()
    {
        $admin_page = add_theme_page(__('Theme Options', CURRENT_THEME), __('Theme Options', CURRENT_THEME), 'manage_options', 'mytheme-options', array(&$this, 'display_page'));
        add_action('admin_print_scripts-' . $admin_page, array(&$this, 'scripts'));
        add_action('admin_print_styles-' . $admin_page, array(&$this, 'styles'));
    }

    /**
     * Create settings field
     *
     * @since 1.0
     */
    public function create_setting($args = array())
    {

        $defaults = array(
            'id' => 'default_field',
            'title' => __('Default Field', CURRENT_THEME),
            'desc' => __('This is a default description.', CURRENT_THEME),
            'std' => '',
            'type' => 'text',
            'section' => 'general',
            'choices' => array(),
            'pattern' => '',
            'class' => ''
        );

        extract(wp_parse_args($args, $defaults));

        $field_args = array(
            'type' => $type,
            'id' => $id,
            'desc' => $desc,
            'std' => $std,
            'choices' => $choices,
            'label_for' => $id,
            'pattern' => $pattern,
            'class' => $class
        );

        if ($type == 'checkbox')
            $this->checkboxes[] = $id;

        add_settings_field($id, $title, array($this, 'display_setting'), 'mytheme-options', $section, $field_args);
    }

    /**
     *
     * Display options page
     *
     * @since 1.0
     */
    public function display_page()
    {

        echo '<div class="wrap">
	<div class="icon32" id="icon-options-general"></div>
	<h2>' . __('Theme Options', CURRENT_THEME) . '</h2>';

        if (isset($_GET['settings-updated']) && $_GET['settings-updated'] == true)
            echo '<div class="updated fade"><p>' . __('Theme options updated.', CURRENT_THEME) . '</p></div>';

        echo '<form action="options.php" method="post">';
        settings_fields('templatetoaster_theme_options');
        echo '<div class="ui-tabs">
			<ul class="ui-tabs-nav">';

        foreach ($this->sections as $section_slug => $section)
            echo '<li><a href="#' . $section_slug . '">' . $section . '</a></li>';

        echo '</ul>';
        do_settings_sections($_GET['page']);

        echo '</div>
		
		<p class="submit">' .
            get_submit_button(__('Save Options', CURRENT_THEME), 'button-primary', 'templatetoaster_theme_options[submit]', false)
            . '</p>
		
	</form>';
        echo '</div>';
    }

    /**
     * Description for section
     *
     * @since 1.0
     */
    public function display_menu_section()
    {

        // code
    }

    /**
     * Description for About section
     *
     * @since 1.0
     */
    public function display_colorscheme_section()
    {

        // This displays on the "About" tab. Echo regular HTML here, like so:
        echo '<br/><p>' . __('Modify this theme using&nbsp;', CURRENT_THEME) . '<a class="tt_link"
                            href="http://templatetoaster.com/wordpress-theme"
                            target="_blank">' . __('TemplateToaster', CURRENT_THEME) . '</a></p>';

    }

    public function display_colors_section()
    {
        echo '<div id="picker"></div>';

    }

    /**
     * HTML output for text field
     *
     * @since 1.0
     */
    public function display_setting($args = array())
    {

        extract($args);

        $options = get_option('templatetoaster_theme_options');

        if (!isset($options[$id]) && $type != 'checkbox')
            $options[$id] = $std;
        elseif (!isset($options[$id]))
            $options[$id] = 0;

        $field_class = '';
        if ($class != '')
            $field_class = ' ' . $class;

        switch ($type) {

            case 'checkbox':
                echo '<div class="normal-toggle-button">';
                echo '<input class="checkbox' . $field_class . '" type="checkbox" id="' . $id . '" name="templatetoaster_theme_options[' . $id . ']" value="1" ' . checked($options[$id], 1, false) . ' /> ';
                echo '</div>';
                break;

            case 'select':
                echo '<select class="select' . $field_class . '" name="templatetoaster_theme_options[' . $id . ']">';

                foreach ($choices as $value => $label)
                    echo '<option value="' . esc_attr($value) . '"' . selected($options[$id], $value, false) . '>' . $label . '</option>';

                echo '</select>';

                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;

            case 'radio':
                $i = 0;
                foreach ($choices as $value => $label) {
                    echo '<input class="radio' . $field_class . '" type="radio" name="templatetoaster_theme_options[' . $id . ']" id="' . $id . $i . '" value="' . esc_attr($value) . '" ' . checked($options[$id], $value, false) . '> <label for="' . $id . $i . '">' . $label . '</label>';
                    if ($i < count($options) - 1)
                        echo '<br />';
                    $i++;
                }

                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;

            case 'textarea':
                echo '<textarea class="' . $field_class . '" id="' . $id . '" name="templatetoaster_theme_options[' . $id . ']" placeholder="' . $std . '" rows="5" cols="30">' . wp_htmledit_pre($options[$id]) . '</textarea>';

                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;

            case 'password':
                echo '<input class="regular-text' . $field_class . '" type="password" id="' . $id . '" name="templatetoaster_theme_options[' . $id . ']" value="' . esc_attr($options[$id]) . '" />';

                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;

            case 'colorpicker':
                $value = esc_attr($options[$id]);
                if (empty($value)) {
                    $value = "#";
                }


                echo '<input class="' . $field_class . '" type="text" id="' . $id . '"name="templatetoaster_theme_options[' . $id . ']" placeholder="' . $std . '" value="' . $value . '" />';
                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;


            case 'text':
            default:
                if ($pattern != '') {
                    echo '<input class="regular-text' . $field_class . '" type="text" id="' . $id . '" name="templatetoaster_theme_options[' . $id . ']" placeholder="' . $std . '" value="' . esc_attr($options[$id]) . '" pattern="' . $pattern . '"/>';
                } else {
                    echo '<input class="regular-text' . $field_class . '" type="text" id="' . $id . '" name="templatetoaster_theme_options[' . $id . ']" placeholder="' . $std . '" value="' . esc_attr($options[$id]) . '"/>';
                }

                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;

            case 'media':
            default:
                echo '<input class="upload' . $field_class . '" type="text" id="' . $id . '" name="templatetoaster_theme_options[' . $id . ']" placeholder="' . $std . '" value="' . esc_attr($options[$id]) . '" />';
                echo '&nbsp;<input type="button" class="ttrbutton btn" value="' . __('Upload', CURRENT_THEME) . '"/>';
                if ($desc != '')
                    echo '<br /><span class="description">' . $desc . '</span>';

                break;


        }

    }

    /* Settings and defaults */


    /* Color Scheme Settings
    ==========================================*/
    public function get_options()
    {
        $menulogo = get_template_directory_uri() . '/menulogo.png';
        $gototop = get_template_directory_uri() . '/images/Default/gototop.png';
        $this->settings['ttr_colorscheme'] = array(
            'title' => __("Select Your Color Scheme", CURRENT_THEME),
            'desc' => __("Select Your Color Scheme", CURRENT_THEME),
            'type' => 'select',
            'std' => 'Default',
            'choices' => $this->valid_colorscheme(),

            'section' => 'colorscheme'
        );

        /* Header Settings
        ==========================================*/

        $this->settings['ttr_site_title_enable'] = array(
            'title' => __("Display Website Title", CURRENT_THEME),
            'desc' => __("Enable/Disable Website Title", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'header'
        );

        $this->settings['ttr_font_size_title'] = array(
            'title' => __("Website Title Font Size", CURRENT_THEME),
            'desc' => __("Enter the font size of Site title here", CURRENT_THEME),
            'std' => '30',
            'pattern' => '\d+',
            'type' => 'text',
            'section' => 'header'
        );

        $this->settings['ttr_heading_tag_title'] = array(
            'title' => __("Heading Tag for Website Title", CURRENT_THEME),
            'desc' => __("Choose heading tag for Site Title", CURRENT_THEME),
            'type' => 'select',
            'std' => 'h1',
            'choices' => $this->valid_headings(),
            'section' => 'header'
        );
        $this->settings['ttr_site_slogan_enable'] = array(
            'title' => __("Display Website Slogan", CURRENT_THEME),
            'desc' => __("Check this box if you would like to ENABLE the site slogan", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'header'
        );
        $this->settings['ttr_font_size_slogan'] = array(
            'title' => __("Website Slogan Font Size", CURRENT_THEME),
            'desc' => __("Enter the font size of Site Slogan", CURRENT_THEME),
            'std' => '22',
            'pattern' => '\d+',
            'type' => 'text',
            'section' => 'header'
        );
        $this->settings['ttr_heading_tag_slogan'] = array(
            'title' => __("Heading Tag for Website Slogan", CURRENT_THEME),
            'desc' => __("Enter the font size of Site Slogan", CURRENT_THEME),
            'type' => 'select',
            'std' => 'h2',
            'choices' => $this->valid_headings(),
            'section' => 'header'
        );

        /* Menu Settings
		==========================================*/

        $this->settings['ttr_menu_logo_enable'] = array(
            'title' => __("Display Website Logo", CURRENT_THEME),
            'desc' => __("Check this box if you would like to ENABLE the header logo", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'menuoptions'
        );
        $this->settings['ttr_logo'] = array(
            'title' => __("Upload your website logo", CURRENT_THEME),
            'desc' => __("Upload your website logo", CURRENT_THEME),
            'std' => $menulogo,
            'type' => 'media',
            'section' => 'menuoptions'
        );
        $this->settings['ttr_logo_image_width'] = array(
            'title' => __("Logo Image Width(in px.)", CURRENT_THEME),
            'desc' => __("Enter width for logo", CURRENT_THEME),
            'std' => '',
            'pattern' => '\d+',
            'type' => 'text',
            'section' => 'menuoptions'
        );
        $this->settings['ttr_logo_image_height'] = array(
            'title' => __("Logo Image Height(in px.)", CURRENT_THEME),
            'desc' => __("Enter width for logo", CURRENT_THEME),
            'std' => '',
            'pattern' => '\d+',
            'type' => 'text',
            'section' => 'menuoptions'
        );

        /* Post/Content Settings
        ==========================================*/

        $this->settings['ttr_featured_post'] = array(
            'title' => __('Number of Featured Posts', CURRENT_THEME),
            'desc' => __('How many posts would you like to be displayed as featured on the front page?', CURRENT_THEME),
            'std' => '1',
            'pattern' => '\d+',
            'type' => 'text',
            'section' => 'postcontent'
        );

        $this->settings['ttr_post_layout'] = array(
            'title' => __('Number of Columns', CURRENT_THEME),
            'desc' => __('How many columns would you like to display the posts after featured posts', CURRENT_THEME),
            'std' => '3',
            'pattern' => '\d+',
            'type' => 'text',
            'section' => 'postcontent'
        );
        $this->settings['ttr_page_breadcrumb'] = array(
            'title' => __('Show Breadcrumbs On Page', CURRENT_THEME),
            'desc' => __('Check this box if you would like to ENABLE the Breadcrumbs On Page', CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'postcontent'
        );
        $this->settings['ttr_post_breadcrumb'] = array(
            'title' => __('Show Breadcrumbs On Post', CURRENT_THEME),
            'desc' => __('Check this box if you would like to ENABLE the Breadcrumbs On Post', CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'postcontent'
        );
        $this->settings['ttr_breadcrumb_text'] = array(
            'title' => __('Breadcrumbs Prefix', CURRENT_THEME),
            'desc' => __('Set breadcrumbs prefix', CURRENT_THEME),
            'std' => '',
            'type' => 'text',
            'section' => 'postcontent'
        );
        $this->settings['ttr_breadcrumb_text_separator'] = array(
            'title' => __('Breadcrumbs Separator', CURRENT_THEME),
            'desc' => __('Eg. &amp;raquo; for "&raquo;", &amp;rsaquo; for "&rsaquo;" and &amp;#47; for "&#47;"', CURRENT_THEME),
            'std' => '&raquo;',
            'type' => 'text',
            'section' => 'postcontent'
        );

        /* Sidebar Settings
        ==========================================*/

        $this->settings['ttr_font_size_block'] = array(
            'title' => __("Block Heading Font Size", CURRENT_THEME),
            'desc' => __("Enter the font size of Block Heading.", CURRENT_THEME),
            'std' => '14',
            'pattern' => '\d+',
            'type' => 'text',
            'section' => 'sidebar'
        );
        $this->settings['ttr_heading_tag_block'] = array(
            'title' => __("Heading Tag for Block Heading", CURRENT_THEME),
            'desc' => __("Choose heading tag for Block Heading", CURRENT_THEME),
            'type' => 'select',
            'std' => 'h3',
            'choices' => $this->valid_headings(),
            'section' => 'sidebar'
        );

        /* Footer Settings
        ==========================================*/

        $this->settings['ttr_copyright_text'] = array(
            'title' => __("Footer Copyright Text", CURRENT_THEME),
            'desc' => __("Enter copyright text", CURRENT_THEME),
            'std' => '&copy; 2014',
            'type' => 'textarea',
            'section' => 'footer'
        );
        $this->settings['ttr_copyright_url'] = array(
            'title' => __("Footer Copyright URL", CURRENT_THEME),
            'desc' => __("Enter copyright url", CURRENT_THEME),
            'std' => '',
            'type' => 'textarea',
            'section' => 'footer'
        );
        $this->settings['ttr_copyright_disable'] = array(
            'title' => __("Display Footer Copyright", CURRENT_THEME),
            'desc' => __("Check this box if you would like to ENABLE the footer copyright", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'footer'
        );
        $this->settings['ttr_font_size_copyright'] = array(
            'title' => __("Footer Copyright Font Size", CURRENT_THEME),
            'desc' => __("Enter the font size of Footer Copyright", CURRENT_THEME),
            'std' => '',
            'type' => 'text',
            'section' => 'footer'
        );
        $this->settings['ttr_font_size_designedby'] = array(
            'title' => __("Footer Designed By Font Size", CURRENT_THEME),
            'desc' => __("Enter the font size of Footer Designed By", CURRENT_THEME),
            'std' => '',
            'type' => 'text',
            'section' => 'footer'
        );
        $this->settings['ttr_font_size_designedbylink'] = array(
            'title' => __("Footer Designed By Link Font Size", CURRENT_THEME),
            'desc' => __("Enter the font size of Footer Designed By Link", CURRENT_THEME),
            'std' => '',
            'type' => 'text',
            'section' => 'footer'
        );
        $this->settings['ttr_no_follow'] = array(
            'title' => __("Enable rel=\"nofollow\"", CURRENT_THEME),
            'desc' => __("Check this box if you would like to ENABLE rel=follow", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'footer'
        );

        /* General Settings
       ==========================================*/

        $this->settings['ttr_custom_style'] = array(
            'title' => __("Custom CSS", CURRENT_THEME),
            'desc' => __("Text Box for custom css", CURRENT_THEME),
            'std' => '',
            'type' => 'textarea',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_all_page_title'] = array(
            'title' => __("Display All Page Titles", CURRENT_THEME),
            'desc' => __("On/Off the page title", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_all_post_title'] = array(
            'title' => __("Display All Post Titles", CURRENT_THEME),
            'desc' => __("On/Off the post title", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_remove_date'] = array(
            'title' => __("Display Post Date", CURRENT_THEME),
            'desc' => __("On/Off the post date", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_remove_author_name'] = array(
            'title' => __("Display Author Name", CURRENT_THEME),
            'desc' => __("On/Off the author name", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_remove_post_category'] = array(
            'title' => __("Show Post Category", CURRENT_THEME),
            'desc' => __("Show Post Category", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_post_navigation'] = array(
            'title' => __("Display Navigation", CURRENT_THEME),
            'desc' => __("Show/Hide navigation", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_older_newer_posts'] = array(
            'title' => __("Display Older/Newer Posts Link", CURRENT_THEME),
            'desc' => __("Show/Hide Older/Newer Posts Link", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_post_navigation_post'] = array(
            'title' => __("Display Post Navigation", CURRENT_THEME),
            'desc' => __("Show/Hide post navigation", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_previous_next_links'] = array(
            'title' => __("Display Previous/next Posts Link", CURRENT_THEME),
            'desc' => __("Show/Hide Previous/next  Posts Link", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_pagination_link_posts'] = array(
            'title' => __("Display Pagination Link Of Post Pages", CURRENT_THEME),
            'desc' => __("Show/Hide Pagination Link Of Post Pages", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_comments_closed_text'] = array(
            'title' => __("Display 'Comments are closed' Text", CURRENT_THEME),
            'desc' => __("Show/Hide 'Comments are closed' Text", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_comments_list'] = array(
            'title' => __("Display Comments List", CURRENT_THEME),
            'desc' => __("Show/Hide Comments ", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_comments_form'] = array(
            'title' => __("Display Comments Form", CURRENT_THEME),
            'desc' => __("Show/Hide Comment form ", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_comment_list_form'] = array(
            'title' => __("Show Comments list", CURRENT_THEME),
            'desc' => __("Check this box to show comment form below comments list.", CURRENT_THEME),
            'type' => 'radio',
            'std' => 'choice1',
            'choices' => array(
                'choice1' => __('Above Comment Form', CURRENT_THEME),
                'choice2' => __('Below Comment Form', CURRENT_THEME)
            ),
            'section' => 'generaloptions'
        );
        $this->settings['ttr_avatar_size'] = array(
            'title' => __("Avatar Size", CURRENT_THEME),
            'desc' => __("Set Avatar size ", CURRENT_THEME),
            'std' => '75',
            'pattern' => '\d+',
            'type' => 'text',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_back_to_top'] = array(
            'title' => __("Display Back To Top Button", CURRENT_THEME),
            'desc' => __("on/off the back to top button", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_icon_back_to_top'] = array(
            'title' => __("Choose icon for Back To Top Button", CURRENT_THEME),
            'desc' => __("Choose icon for back to top button", CURRENT_THEME),
            'std' => $gototop,
            'type' => 'media',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_read_more'] = array(
            'title' => __("Read More Text", CURRENT_THEME),
            'desc' => __("Change Text For Read More Link", CURRENT_THEME),
            'std' => __("Continue Reading", CURRENT_THEME),
            'type' => 'text',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_read_more_button'] = array(
            'title' => __("Display Button For Read More", CURRENT_THEME),
            'desc' => __("on/off the Read More button", CURRENT_THEME),
            'std' => 0,
            'type' => 'checkbox',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_post1_enable'] = array(
            'title' => __(" 'Read more' on all posts", CURRENT_THEME),
            'desc' => __("on/off the Read More on all posts", CURRENT_THEME),
            'std' => 0,
            'type' => 'checkbox',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_read_length'] = array(
            'title' => __("Word Count", CURRENT_THEME),
            'desc' => __("After how many words you need read more", CURRENT_THEME),
            'std' => '35',
            'pattern' => '\d+',
            'type' => 'text',
            'section' => 'generaloptions'
        );
        $this->settings['ttr_search_icon_enable'] = array(
            'title' => __("Display Search Icon In Search Widget", CURRENT_THEME),
            'desc' => __("Display/Hide Search Icon", CURRENT_THEME),
            'std' => 0,
            'type' => 'checkbox',
            'section' => 'generaloptions'
        );

        /* Error page Settings
         ===========================================*/

        $this->settings['ttr_error_message_heading'] = array(
            'title' => __("Heading For Error Message", CURRENT_THEME),
            'desc' => __("Change Text For Error Message", CURRENT_THEME),
            'std' => __("This is somewhat embarrassing, isn&rsquo;t it?", CURRENT_THEME),
            'type' => 'textarea',
            'section' => 'error'
        );
        $this->settings['ttr_error_message_content'] = array(
            'title' => __("Content For Error Message", CURRENT_THEME),
            'desc' => __("Change text For Error Message", CURRENT_THEME),
            'std' => __("It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching, or one of the links below, can help.", CURRENT_THEME),
            'type' => 'textarea',
            'section' => 'error'
        );
        $this->settings['ttr_error_message'] = array(
            'title' => __("Enable Content", CURRENT_THEME),
            'desc' => __("Hide/Show Error Message Text", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'error'
        );
        $this->settings['ttr_error_search_box'] = array(
            'title' => __("Enable Search", CURRENT_THEME),
            'desc' => __("Hide/Show Search Box", CURRENT_THEME),
            'std' => 1,
            'type' => 'checkbox',
            'section' => 'error'
        );
        $this->settings['ttr_error_image'] = array(
            'title' => __("Content Image", CURRENT_THEME),
            'desc' => __("Choose Error Image", CURRENT_THEME),
            'std' => '',
            'type' => 'media',
            'section' => 'error'
        );
        $this->settings['ttr_error_image_enable'] = array(
            'title' => __("Enable Image In Content", CURRENT_THEME),
            'desc' => __("Hide/Show error image", CURRENT_THEME),
            'std' => 0,
            'type' => 'checkbox',
            'section' => 'error'
        );
        $this->settings['ttr_error_image_height'] = array(
            'title' => __("Content Image Height", CURRENT_THEME),
            'desc' => __("Height Of The Error Image", CURRENT_THEME),
            'std' => '300',
            'pattern' => '\d+',
            'type' => 'text',
            'section' => 'error'
        );
        $this->settings['ttr_error_image_width'] = array(
            'title' => __("Content Image Width", CURRENT_THEME),
            'desc' => __("Width of The Error Image", CURRENT_THEME),
            'std' => '300',
            'pattern' => '\d+',
            'type' => 'text',
            'section' => 'error'
        );
        $this->settings['ttr_error_home_redirect'] = array(
            'title' => __("Redirect To Home Page(If Error Page Occurs)", CURRENT_THEME),
            'desc' => __("Redirect to Home Page While Error Occur", CURRENT_THEME),
            'std' => 0,
            'type' => 'checkbox',
            'section' => 'error'
        );

        /* Color page Settings
        ===========================================*/

        $this->settings['ttr_title'] = array(
            'title' => __('Site Title Color', CURRENT_THEME),
            'desc' => __('Choose site title color', CURRENT_THEME),
            'std' => '',
            'class' => 'colorwell',
            'type' => 'colorpicker',
            'section' => 'colors'
        );
        $this->settings['ttr_slogan'] = array(
            'title' => __('Site Slogan Color', CURRENT_THEME),
            'desc' => __('Choose site slogan color', CURRENT_THEME),
            'std' => '',
            'class' => 'colorwell',
            'type' => 'colorpicker',
            'section' => 'colors'
        );
        $this->settings['ttr_copyright'] = array(
            'title' => __('Footer Copyright Color', CURRENT_THEME),
            'desc' => __('Choose footer copyrightcolor', CURRENT_THEME),
            'std' => '',
            'class' => 'colorwell',
            'type' => 'colorpicker',
            'section' => 'colors'
        );
        $this->settings['ttr_designedby'] = array(
            'title' => __('Footer Designed By Color', CURRENT_THEME),
            'desc' => __('Choose footer Designed By color', CURRENT_THEME),
            'std' => '',
            'class' => 'colorwell',
            'type' => 'colorpicker',
            'section' => 'colors'
        );
        $this->settings['ttr_designedbylink'] = array(
            'title' => __('Footer Designed By Link Color', CURRENT_THEME),
            'desc' => __('Choose footer Designed By link color', CURRENT_THEME),
            'std' => '',
            'class' => 'colorwell',
            'type' => 'colorpicker',
            'section' => 'colors'
        );
        $this->settings['ttr_blockheading'] = array(
            'title' => __('Block Heading Color', CURRENT_THEME),
            'desc' => __('Choose block heading color', CURRENT_THEME),
            'std' => '',
            'class' => 'colorwell',
            'type' => 'colorpicker',
            'section' => 'colors'
        );
        $this->settings['ttr_post_title_color'] = array(
            'title' => __('Page/Post Title Normal Color', CURRENT_THEME),
            'desc' => __('Choose Page/Post title normal color', CURRENT_THEME),
            'std' => '',
            'class' => 'colorwell',
            'type' => 'colorpicker',
            'section' => 'colors'
        );
        $this->settings['ttr_post_title_hover_color'] = array(
            'title' => __('Post Title Hover Color', CURRENT_THEME),
            'desc' => __('Choose post title hover color', CURRENT_THEME),
            'std' => '',
            'class' => 'colorwell',
            'type' => 'colorpicker',
            'section' => 'colors'
        );


    }

    /**
     * Initialize settings to their default values
     *
     * @since 1.0
     */
    public function initialize_settings()
    {

        $default_settings = array();
        foreach ($this->settings as $id => $setting) {
            if ($setting['type'] != 'heading')
                $default_settings[$id] = $setting['std'];
        }

        update_option('templatetoaster_theme_options', $default_settings);

    }

    /**
     * Register settings
     *
     * @since 1.0
     */
    public function register_settings()
    {

        register_setting('templatetoaster_theme_options', 'templatetoaster_theme_options', array(&$this, 'validate_settings'));
        foreach ($this->sections as $slug => $title) {
            if ($slug == 'colorscheme')
                add_settings_section($slug, $title, array(&$this, 'display_colorscheme_section'), 'mytheme-options');
            elseif ($slug == 'colors')
                add_settings_section($slug, $title, array(&$this, 'display_colors_section'), 'mytheme-options');

            else
                add_settings_section($slug, $title, array(&$this, 'display_menu_section'), 'mytheme-options');
        }
        $this->get_options();

        foreach ($this->settings as $id => $setting) {
            $setting['id'] = $id;
            $this->create_setting($setting);
        }
    }

    public function scripts()
    {
        wp_register_script('uitabs', get_template_directory_uri() . '/js/uitabs.js', array('jquery', 'wp-color-picker'), '1.0.0', false);
        wp_enqueue_script('uitabs');
        wp_localize_script('uitabs', 'pass_data', $this->sections);

    }

    public function styles()
    {

        wp_enqueue_style('wp-color-picker');
    }


    /**
     * Validate settings
     *
     * @since 1.0
     */
    public function validate_settings($input)
    {

        $options = get_option('templatetoaster_theme_options');

        /* Checkbox validation */
        foreach (array('ttr_site_title_enable', 'ttr_site_slogan_enable', 'ttr_menu_logo_enable', 'ttr_page_breadcrumb', 'ttr_post_breadcrumb', 'ttr_copyright_disable', 'ttr_no_follow', 'ttr_all_page_title', 'ttr_all_post_title', 'ttr_remove_date', 'ttr_remove_author_name', 'ttr_remove_post_category', 'ttr_post_navigation', 'ttr_older_newer_posts', 'ttr_post_navigation_post', 'ttr_previous_next_links', 'ttr_pagination_link_posts', 'ttr_comments_closed_text', 'ttr_comments_list', 'ttr_comments_form', 'ttr_back_to_top', 'ttr_read_more_button', 'ttr_post1_enable', 'ttr_search_icon_enable', 'ttr_error_message', 'ttr_error_search_box', 'ttr_error_image_enable', 'ttr_error_home_redirect') as $id) {
            if (isset($options[$id]) && !isset($input[$id]))
                unset($options[$id]);
        }

        /* URL validation */
        foreach (array('ttr_logo', 'ttr_copyright_url', 'ttr_icon_back_to_top', 'ttr_error_image') as $url) {
            $input[$url] = esc_url_raw($input[$url]);

        }

        /* Text Field validation */
        foreach (array('ttr_breadcrumb_text', 'ttr_breadcrumb_text_separator', 'ttr_read_more') as $text) {
            $input[$text] = sanitize_text_field($input[$text]);
        }

        /* Textarea validation */
        foreach (array('ttr_copyright_text', 'ttr_copyright_url', 'ttr_error_message_heading', 'ttr_error_message_content') as $textarea) {
            $input[$textarea] = wp_filter_nohtml_kses($input[$textarea]);
        }

        /* Custom CSS */
        $input['ttr_custom_style'] = wp_kses_stripslashes($input['ttr_custom_style']);

        /* Select Box validation */

        $input['ttr_colorscheme'] = (array_key_exists($input['ttr_colorscheme'], $this->valid_colorscheme()) ? $input['ttr_colorscheme'] : $options['ttr_colorscheme']);
        $input['ttr_heading_tag_title'] = (array_key_exists($input['ttr_heading_tag_title'], $this->valid_colorscheme()) ? $input['ttr_heading_tag_title'] : $options['ttr_heading_tag_title']);
        $input['ttr_heading_tag_slogan'] = (array_key_exists($input['ttr_heading_tag_slogan'], $this->valid_colorscheme()) ? $input['ttr_heading_tag_slogan'] : $options['ttr_heading_tag_slogan']);
        $input['ttr_heading_tag_block'] = (array_key_exists($input['ttr_heading_tag_block'], $this->valid_colorscheme()) ? $input['ttr_heading_tag_block'] : $options['ttr_heading_tag_block']);


        /*Color Picker validation */
        foreach (array('ttr_title', 'ttr_slogan', 'ttr_copyright', 'ttr_designedby', 'ttr_designedbylink', 'ttr_blockheading', 'ttr_post_title_color', 'ttr_post_title_hover_color') as $color) {
            // Validate  Color
            $colorvalue = trim($input[$color]);
            $colorvalue = strip_tags(stripslashes($colorvalue));
            if (FALSE === $this->check_color($colorvalue)) {
                $input[$color] = $options[$color]; // Get the previous valid value
            } else {
                $input[$color] = $colorvalue;
            }
        }
        return $input;
    }

    public function check_color($value)
    {

        if (preg_match('/^#[a-f0-9]{6}$/i', $value)) { // if user insert a HEX color with #
            return true;
        }

        return false;
    }

    public function valid_colorscheme()
    {
        $colorscheme = array(
            'choice1' => __("Default", CURRENT_THEME),
            'choice2' => __("Red", CURRENT_THEME),
            'choice3' => __("Skyblue", CURRENT_THEME),
            'choice4' => __("Pink", CURRENT_THEME),
            'choice5' => __("SeaGreen", CURRENT_THEME),
            'choice6' => __("Green", CURRENT_THEME));

        return $colorscheme;
    }

    public function valid_headings()
    {
        $headings = array(
            'choice1' => __("h1", CURRENT_THEME),
            'choice2' => __("h2", CURRENT_THEME),
            'choice3' => __("h3", CURRENT_THEME),
            'choice4' => __("h4", CURRENT_THEME),
            'choice5' => __("h5", CURRENT_THEME),
            'choice6' => __("h6", CURRENT_THEME)
        );
        return $headings;
    }


}

$theme_options = new Templatetoaster_Theme_Options();

?>