<?php
/**
 * templatetoaster functions and definitions
 *
 * @package templatetoaster
 */

ob_start();
global $templatetoaster_cssprefix, $templatetoaster_theme_widget_args;

/**
 * TemplateToaster functions and definitions
 *
 * Sets up the theme and provides some helper functions. Some helper functions
 * are used in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * The first function, templatetoaster_theme_setup(), sets up the theme by registering support
 * for various features in WordPress, such as post thumbnails, navigation menus, and the like.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook. The hook can be removed by using remove_action() or
 * remove_filter() and you can attach your own function to the hook.
 *
 * We can remove the parent theme's hook only after it is attached, which means we need to
 * wait until setting up the child theme:
 *
 * <code>
 * add_action( 'after_setup_theme', 'my_child_templatetoaster_theme_setup' );
 * function my_child_templatetoaster_theme_setup() {
 *    ...
 * }
 * </code>
 *
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
@define('CURRENT_THEME', 'templatetoaster');
global $templatetoaster_theme_widget_args;


if (!isset($content_width))
    $content_width = 900;


if (!function_exists('templatetoaster_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function templatetoaster_setup()
    {

        /*
         * Make theme available for translation.
         * Translations can be filed in the /languages/ directory.
         * If you're building a theme based on templatetoaster, use a find and replace
         * to change 'templatetoaster' to the name of your theme in all the template files
         */
        load_theme_textdomain(CURRENT_THEME, get_template_directory() . '/languages');

        require_once(get_template_directory() . '/inc/theme-options.php');
        global $templatetoaster_options, $templatetoaster_cssprefix;
        $templatetoaster_options = get_option('templatetoaster_theme_options');

        require_once(get_template_directory() . '/inc/widgetinit.php');

        require_once(get_template_directory() . '/inc/custommenu.php');

        // This theme styles the visual editor with editor-style.css to match the theme style.
        add_editor_style();

        /*
         * Enable support for Post Thumbnails on posts and pages.
         *
         * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
         */
        add_theme_support('post-thumbnails');

        //set_post_thumbnail_size(150, 150, true);

        // Add default posts and comments RSS feed links to head.
        add_theme_support('automatic-feed-links');

        /*
         * Let WordPress manage the document title.
         * By adding theme support, we declare that this theme does not use a
         * hard-coded <title> tag in the document head, and expect WordPress to
         * provide it for us.
         */
        add_theme_support('title-tag');
        add_theme_support('woocommerce');


        // This theme uses wp_nav_menu() in one location.
        register_nav_menus(array(
            'primary' => __('Menu', CURRENT_THEME),
        ));

        // Set up the WordPress core custom background feature.
        add_theme_support('custom-background', apply_filters('templatetoaster_custom_background_args', array(
            'default-color' => 'ffffff',
            'default-image' => '',
        )));

        /*
         * Enable support for Post Formats.
         * See http://codex.wordpress.org/Post_Formats
         */
        add_theme_support('post-formats', array(
            'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video'
        ));

        add_filter('use_default_gallery_style', '__return_false');

        // Default custom headers packaged with the theme. %s is a placeholder for the theme template directory URI.

        register_default_headers(array(
            'wheel' => array(
                'url' => '%s/images/headers/wheel.jpg',
                'thumbnail_url' => '%s/images/headers/wheel-thumbnail.jpg',
                /* translators: header image description */
                'description' => __('Wheel', CURRENT_THEME)
            ),
            'shore' => array(
                'url' => '%s/images/headers/shore.jpg',
                'thumbnail_url' => '%s/images/headers/shore-thumbnail.jpg',
                /* translators: header image description */
                'description' => __('Shore', CURRENT_THEME)
            ),
            'trolley' => array(
                'url' => '%s/images/headers/trolley.jpg',
                'thumbnail_url' => '%s/images/headers/trolley-thumbnail.jpg',
                /* translators: header image description */
                'description' => __('Trolley', CURRENT_THEME)
            ),
            'pine-cone' => array(
                'url' => '%s/images/headers/pine-cone.jpg',
                'thumbnail_url' => '%s/images/headers/pine-cone-thumbnail.jpg',
                /* translators: header image description */
                'description' => __('Pine Cone', CURRENT_THEME)
            ),
            'chessboard' => array(
                'url' => '%s/images/headers/chessboard.jpg',
                'thumbnail_url' => '%s/images/headers/chessboard-thumbnail.jpg',
                /* translators: header image description */
                'description' => __('Chessboard', CURRENT_THEME)
            ),
            'lanterns' => array(
                'url' => '%s/images/headers/lanterns.jpg',
                'thumbnail_url' => '%s/images/headers/lanterns-thumbnail.jpg',
                /* translators: header image description */
                'description' => __('Lanterns', CURRENT_THEME)
            ),
            'willow' => array(
                'url' => '%s/images/headers/willow.jpg',
                'thumbnail_url' => '%s/images/headers/willow-thumbnail.jpg',
                /* translators: header image description */
                'description' => __('Willow', CURRENT_THEME)
            ),
            'hanoi' => array(
                'url' => '%s/images/headers/hanoi.jpg',
                'thumbnail_url' => '%s/images/headers/hanoi-thumbnail.jpg',
                /* translators: header image description */
                'description' => __('Hanoi Plant', CURRENT_THEME)
            )
        ));
    }
endif; // templatetoaster_setup
add_action('after_setup_theme', 'templatetoaster_setup');

/**
 * Returns a "Continue Reading" link for excerpts
 */
function templatetoaster_continue_reading_link()
{
    if (templatetoaster_theme_option('ttr_read_more_button')) {
        return ' <a href="' . esc_url(get_permalink()) . '">' . __('<span class="btn btn-default">' . templatetoaster_theme_option('ttr_read_more') . '<span class="meta-nav">&rarr;</span></span>', CURRENT_THEME) . '</a>';
    } else {
        return ' <a href="' . esc_url(get_permalink()) . '">' . __(templatetoaster_theme_option('ttr_read_more') . '<span class="meta-nav">&rarr;</span>', CURRENT_THEME) . '</a>';

    }
}

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with an ellipsis and templatetoaster_continue_reading_link().
 *
 * To override this in a child theme, remove the filter and add your own
 * function tied to the excerpt_more filter hook.
 */
function templatetoaster_auto_excerpt_more($more)
{
    return ' &hellip;' . templatetoaster_continue_reading_link();
}

add_filter('excerpt_more', 'templatetoaster_auto_excerpt_more');

/**
 * Trim the content lenght without deleting tags
 */
function templatetoaster_trim_words($text, $more = null)
{
    $num_words = templatetoaster_theme_option('ttr_read_length');
    if (null === $more)
        $more = '&hellip;';

    $text = wp_strip_all_tags($text);

    $text = strip_shortcodes($text);
    /* translators: If your word count is based on single characters (East Asian characters),
		 	 enter 'characters'. Otherwise, enter 'words'. Do not translate into your own language. */
    if ('characters' == _x('words', 'word count: words or characters?', CURRENT_THEME) && preg_match('/^utf\-?8$/i', get_option('blog_charset'))) {
        $text = trim(preg_replace("/[\n\r\t ]+/", ' ', $text), ' ');
        preg_match_all('/./u', $text, $words_array);
        $words_array = array_slice($words_array[0], 0, $num_words + 1);
        $sep = '';
    } else {
        $words_array = preg_split("/[\n\r\t ]+/", $text, $num_words + 1, PREG_SPLIT_NO_EMPTY);
        $sep = ' ';
    }
    if (count($words_array) > $num_words) {
        array_pop($words_array);
        $text = implode($sep, $words_array);
        $text = $text . $more;

    } else {
        $text = implode($sep, $words_array);
    }

    return force_balance_tags($text);
}


/**
 * Read more link function on enabling the tag in theme options
 */
function templatetoaster_content_filter($content)
{
    global $post;
    $morelink = ' &hellip;' . templatetoaster_continue_reading_link();
    if (templatetoaster_theme_option('ttr_post1_enable') && !is_single() && !is_page() && empty($post->post_excerpt) && !is_feed()) {

        return templatetoaster_trim_words($content, $more = $morelink);
    } else if (!empty($post->post_excerpt) && !is_single() && !is_page() && templatetoaster_theme_option('ttr_post1_enable') && !is_feed()) {
        return $post->post_excerpt . $morelink;
    } else {
        return $content;
    }
}

add_filter('the_content', 'templatetoaster_content_filter');


/**
 * Adds a pretty "Continue Reading" link to custom post excerpts.
 *
 * To override this link in a child theme, remove the filter and add your own
 * function tied to the get_the_excerpt filter hook.
 */
function templatetoaster_custom_excerpt_more($output)
{
    if (has_excerpt() && !is_attachment()) {
        $output .= templatetoaster_continue_reading_link();
    }
    return $output;
}

add_filter('get_the_excerpt', 'templatetoaster_custom_excerpt_more');

/**
 * Get our wp_nav_menu() fallback, wp_page_menu(), to show a home link.
 */
function templatetoaster_page_menu_args($args)
{
    $args['show_home'] = true;
    return $args;
}

add_filter('wp_page_menu_args', 'templatetoaster_page_menu_args');


/**
 * Display navigation to next/previous pages when applicable
 */
function templatetoaster_content_nav($nav_id)
{
    global $wp_query;
    if ($wp_query->max_num_pages > 1) : ?>
        <nav id="<?php echo esc_attr($nav_id); ?>">
            <?php if (templatetoaster_theme_option('ttr_post_navigation')): ?>
                <h3 class="assistive-text"><?php echo(__('Navigation', CURRENT_THEME)); ?></h3>
            <?php endif; ?>
            <?php
            if (templatetoaster_theme_option('ttr_pagination_link_posts')) {
                global $wp_query;

                $big = 999999999;
                $pge = paginate_links(array(
                    'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                    'prev_next' => True,
                    'format' => '?paged=%#%',
                    'prev_text' => __('Previous', CURRENT_THEME),
                    'next_text' => __('Next', CURRENT_THEME),
                    'current' => max(1, get_query_var('paged')),
                    'type' => 'array',
                    'total' => $wp_query->max_num_pages
                ));
                if ($wp_query->max_num_pages > 1) :
                    ?>
                    <ul class="pagination">
                        <?php
                        foreach ($pge as $page) {
                            if (strpos($page, 'current') !== false) {
                                echo '<li class="active">' . $page . '</li>';
                            } else {
                                echo '<li>' . $page . '</li>';
                            }
                        }
                        ?>
                    </ul>
                <?php endif; ?>
            <?php
            }
            if (templatetoaster_theme_option('ttr_older_newer_posts')) {
                ?>
                <div
                    class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&larr;</span> Older posts', CURRENT_THEME)); ?></div>
                <div
                    class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&rarr;</span>', CURRENT_THEME)); ?></div>
            <?php } ?>
        </nav><!-- #nav-above -->
    <?php endif;
}


/**
 * Return the URL for the first link found in the post content.
 * @return string|bool URL or false when no link is present.
 */
function templatetoaster_url_grabber()
{
    if (!preg_match('/<a\s[^>]*?href=[\'"](.+?)[\'"]/is', get_the_content(), $matches))
        return false;

    return esc_url_raw($matches[1]);
}


/**
 * Count the number of footer sidebars to enable dynamic classes for the footer
 */
function templatetoaster_footer_sidebar_class()
{
    $count = 0;

    if (is_active_sidebar('sidebar-3'))
        $count++;

    if (is_active_sidebar('sidebar-4'))
        $count++;

    if (is_active_sidebar('sidebar-5'))
        $count++;

    $class = '';

    switch ($count) {
        case '1':
            $class = 'one';
            break;
        case '2':
            $class = 'two';
            break;
        case '3':
            $class = 'three';
            break;
    }

    if ($class)
        echo 'class="' . $class . '"';
}

if (!function_exists('templatetoaster_comment')) :

/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own templatetoaster_comment(), and that function will be used instead.
 */
function templatetoaster_comment($comment, $args, $depth)
{
if (is_singular() && comments_open() && get_option('thread_comments'))
    wp_enqueue_script('comment-reply');
$GLOBALS['comment'] = $comment;
switch ($comment->comment_type) :
case 'pingback' :
case 'trackback' :
?>
<li class="post pingback">
    <p><?php _e('Pingback:', CURRENT_THEME); ?> <?php comment_author_link(); ?><?php edit_comment_link(__('Edit', CURRENT_THEME), '<span class="edit-link">', '</span>'); ?></p>
    <?php
    break;
    default :
    ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">

<div>

    <div class="comment-author vcard">
        <?php
        $avatar_size = 68;
        if ('0' != $comment->comment_parent)
            $avatar_size = 39;

        echo get_avatar($comment, $avatar_size);

        /* translators: 1: comment author, 2: date and time */
        printf('%s on %2$s <span class="says">' . __('said:', CURRENT_THEME) . '</span>', sprintf('<span class="fn">%s</span>', get_comment_author_link()), sprintf('<a href="%s"><time pubdate datetime="%2$s">%3$s</time></a>', esc_url(get_comment_link($comment->comment_ID)), get_comment_time('c'), /* translators: 1: date, 2: time */
            sprintf('%s ' . __('at', CURRENT_THEME) . ' %2$s', get_comment_date(), get_comment_time())));
        ?>

        <?php edit_comment_link(__('Edit', CURRENT_THEME), '<span class="edit-link">', '</span>'); ?>
    </div>
    <!-- .comment-author .vcard -->

    <?php if ($comment->comment_approved == '0') : ?>
        <em class="comment-awaiting-moderation"><?php _e('Your comment is awaiting moderation.', CURRENT_THEME); ?></em>
        <br/>
    <?php endif; ?>
    <!--</footer>-->

    <div class="comment-content"><?php comment_text(); ?></div>

    <div class="reply">
        <?php comment_reply_link(array_merge($args, array('reply_text' => __('Reply <span>&darr;</span>', CURRENT_THEME), 'depth' => $depth, 'max_depth' => $args['max_depth']))); ?>
    </div>
    <!-- .reply -->
</div>
<!-- #comment-## -->

<?php
break;
endswitch;
}
endif; // ends check for templatetoaster_comment()

if (!function_exists('templatetoaster_entry_meta')) :

    /**
     * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
     *
     * Create your own templatetoaster_entry_meta() to override in a child theme.
     * @return void
     */

    function templatetoaster_entry_meta()
    {
        if (is_sticky() && is_home() && !is_paged())
            echo '<span class="featured-post">' . __('Sticky', CURRENT_THEME) . '</span>';

        if (!has_post_format('link') && 'post' == get_post_type())
            templatetoaster_entry_date();

        // Translators: used between list items, there is a space after the comma.
        if (!has_post_format(array('chat', 'status'))):
            $categories_list = get_the_category_list(__(', ', CURRENT_THEME));
            if ($categories_list) {
                if (templatetoaster_theme_option('ttr_remove_post_category'))
                    echo '<span class="categories-links"> ' . $categories_list . ' |</span>';
            }
        endif;

        // Translators: used between list items, there is a space after the comma.
        $tag_list = get_the_tag_list('', __(', ', CURRENT_THEME));
        if ($tag_list) {
            echo '<span class="tags-links"> |' . $tag_list . '</span>';
        }

        // Post author
        if (!has_post_format(array('chat', 'status', 'aside', 'quote'))):
            if ('post' == get_post_type()) {
                printf('<span class="author vcard"><a class="url fn n" href="%s" title="%2$s" rel="author"> %3$s | </a></span>',
                    esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                    esc_attr(sprintf(__('View all posts by %s', CURRENT_THEME), get_the_author())),
                    get_the_author()
                );
            }
        endif;
    }
endif;

if (!function_exists('templatetoaster_entry_date')) :
    /**
     * Prints HTML with date information for current post.
     * Create your own templatetoaster_entry_date() to override in a child theme.
     * @param boolean $echo Whether to echo the date. Default true.
     * @return string The HTML-formatted post date.
     */
    function templatetoaster_entry_date($echo = true)
    {
        if (has_post_format(array('chat', 'status')))
            $format_prefix = _x('%s on %2$s ', '1: post format name. 2: date', CURRENT_THEME);
        else
            $format_prefix = '%2$s ';

        if (templatetoaster_theme_option('ttr_remove_date')):
            $date = sprintf('<span class="date"><a href="%s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a></span>',
                esc_url(get_permalink()),
                esc_attr(sprintf(__('Permalink to %s', CURRENT_THEME), the_title_attribute('echo=0'))),
                esc_attr(get_the_date('c')),
                esc_html(sprintf($format_prefix, get_post_format_string(get_post_format()), get_the_date()))
            );


            if (has_post_format(array('chat'))):
                if ($echo)
                    echo $date;

                return $date;
            else:
                if ($echo)
                    echo $date . '|';

                return $date . '|';
            endif;

        endif;
    }
endif;

function templatetoaster_get_link_url()
{
    $content = get_the_content();
    $has_url = get_url_in_content($content);

    return ($has_url) ? $has_url : apply_filters('the_permalink', get_permalink());
}

if (!function_exists('templatetoaster_posted_on')) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     * Create your own templatetoaster_posted_on to override in a child theme
     */

    function templatetoaster_posted_on($date, $author)
    {

        if (isset($_POST[sanitize_key('wp_customize')]) && $_POST[sanitize_key('wp_customize')] == 'on'):

            echo '<div class="postedon">';
            if (is_sticky() && is_home() && !is_paged()) {
                echo '<span class="featured-post"></span>';
                echo '<span style="clear:both;">' . __('Sticky', CURRENT_THEME) . '</span>';
            }
            if ($date && $author) {

                printf('<span class="meta"> ' . __('Posted on', CURRENT_THEME) . '</span> <img alt="' . __('date', CURRENT_THEME) . '" src="' . get_template_directory_uri() . '/images/datebutton.png"/><a href="%s" title="%2$s" rel="bookmark">&nbsp;<time datetime="%3$s">%4$s</time></a><span class = "meta"> by </span> <a href="%5$s" title="%6$s" rel="author">%7$s</a>',
                    esc_url(get_permalink()),
                    esc_attr(get_the_time()),
                    esc_attr(get_the_date('c')),
                    esc_html(get_the_date()),
                    esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                    sprintf(esc_attr__('View all posts by %s', CURRENT_THEME), get_the_author()),
                    esc_html(get_the_author())
                );
            } else if ($date && !$author) {

                printf('<span class="meta"> ' . __('Posted on', CURRENT_THEME) . '</span> <img alt="' . __('date', CURRENT_THEME) . '" src="' . get_template_directory_uri() . '/images/datebutton.png"/><a href="%s" title="%2$s" rel="bookmark">&nbsp;<time datetime="%3$s">%4$s</time></a><span class = "meta"> by </span><a href="%5$s" title="%6$s" rel="author">%7$s</a>',
                    esc_url(get_permalink()),
                    esc_attr(get_the_time()),
                    esc_attr(get_the_date('c')),
                    esc_html(get_the_date()),
                    esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                    sprintf(esc_attr__('View all posts by %s', CURRENT_THEME), get_the_author()),
                    esc_html(get_the_author())
                );

            } elseif (!$date && $author) {
                printf('<span class="meta"> ' . __('Posted on', CURRENT_THEME) . '</span> <a href="%s" title="%2$s" rel="bookmark">&nbsp;<time datetime="%3$s">%4$s</time></a><span class = "meta"> by </span><a href="%5$s" title="%6$s" rel="author">%7$s</a>',
                    esc_url(get_permalink()),
                    esc_attr(get_the_time()),
                    esc_attr(get_the_date('c')),
                    esc_html(get_the_date()),
                    esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                    sprintf(esc_attr__('View all posts by %s', CURRENT_THEME), get_the_author()),
                    esc_html(get_the_author())
                );
            } else {
                printf('<span class="meta"> ' . __('Posted on', CURRENT_THEME) . '</span> <a href="%s" title="%2$s" rel="bookmark">&nbsp;<time datetime="%3$s">%4$s</time></a><span class = "meta"> by </span><a href="%5$s" title="%6$s" rel="author">%7$s</a>',
                    esc_url(get_permalink()),
                    esc_attr(get_the_time()),
                    esc_attr(get_the_date('c')),
                    esc_html(get_the_date()),
                    esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                    sprintf(esc_attr__('View all posts by %s', CURRENT_THEME), get_the_author()),
                    esc_html(get_the_author())
                );

            }
            echo '</div>';

        else:
            $var_date = templatetoaster_theme_option('ttr_remove_date');
            $var_author = templatetoaster_theme_option('ttr_remove_author_name');
            echo '<div class="postedon">';
            if (is_sticky() && is_home() && !is_paged()) {
                echo '<span class="featured-post"></span>';
                echo '<span style="clear:both;">' . __('Sticky', CURRENT_THEME) . '</span>';
            }
            if ($date && $author) {
                if ($var_date && $var_author) {
                    printf('<span class="meta"> ' . __('Posted on', CURRENT_THEME) . '</span> <img alt="' . __('date', CURRENT_THEME) . '" src="' . get_template_directory_uri() . '/images/datebutton.png"/><a href="%s" title="%2$s" rel="bookmark">&nbsp;<time datetime="%3$s">%4$s</time></a><span class = "meta">  ' . __('by ', CURRENT_THEME) . ' </span><a href="%5$s" title="%6$s" rel="author">%7$s</a>',
                        esc_url(get_permalink()),
                        esc_attr(get_the_time()),
                        esc_attr(get_the_date('c')),
                        esc_html(get_the_date()),
                        esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                        sprintf(esc_attr__('View all posts by %s', CURRENT_THEME), get_the_author()),
                        esc_html(get_the_author())
                    );
                } else if ($var_author) {
                    printf('<span class="meta-sep"> ' . __('Posted by', CURRENT_THEME) . '</span> %s',
                        sprintf('<span class="author vcard"><a class="url fn n" href="%s" title="%2$s">%3$s</a></span>',
                            get_author_posts_url(get_the_author_meta('ID')),
                            sprintf(esc_attr__('View all posts by %s', CURRENT_THEME), get_the_author()),
                            get_the_author())
                    );
                } else if ($var_date) {
                    printf('<span class="meta">  ' . __('Posted on', CURRENT_THEME) . '</span><img alt="' . __('date', CURRENT_THEME) . '" src="' . get_template_directory_uri() . '/images/datebutton.png"/> <time datetime="%3$s">%4$s</time></a>',
                        esc_url(get_permalink()),
                        esc_attr(get_the_time()),
                        esc_attr(get_the_date('c')),
                        esc_html(get_the_date())
                    );
                }
            } else if ($date && !$author) {
                if ($var_date && $var_author) {
                    printf('<span class="meta"> ' . __('Posted on', CURRENT_THEME) . '</span> <img alt="' . __('date', CURRENT_THEME) . '" src="' . get_template_directory_uri() . '/images/datebutton.png"/><a href="%s" title="%2$s" rel="bookmark">&nbsp;<time datetime="%3$s">%4$s</time></a><span class = "meta"> ' . __('by ', CURRENT_THEME) . '</span><a href="%5$s" title="%6$s" rel="author">%7$s</a>',
                        esc_url(get_permalink()),
                        esc_attr(get_the_time()),
                        esc_attr(get_the_date('c')),
                        esc_html(get_the_date()),
                        esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                        sprintf(esc_attr__('View all posts by %s', CURRENT_THEME), get_the_author()),
                        esc_html(get_the_author())
                    );
                } else if ($var_author) {
                    printf('<span class="meta-sep"> ' . __('Posted by', CURRENT_THEME) . '</span> %s ',
                        sprintf('<span class="author vcard"><a class="url fn n" href="%s" title="%2$s">%3$s</a></span>',
                            get_author_posts_url(get_the_author_meta('ID')),
                            sprintf(esc_attr__('View all posts by %s', CURRENT_THEME), get_the_author()),
                            get_the_author())
                    );
                } else if ($var_date) {
                    printf('<span class="meta"> ' . __('Posted on', CURRENT_THEME) . '</span> <img alt="' . __('date', CURRENT_THEME) . '" src="' . get_template_directory_uri() . '/images/datebutton.png"/> <time datetime="%3$s">%4$s</time></a>',
                        esc_url(get_permalink()),
                        esc_attr(get_the_time()),
                        esc_attr(get_the_date('c')),
                        esc_html(get_the_date())
                    );
                }
            } elseif (!$date && $author) {
                if ($var_date && $var_author) {

                    printf('<span class="meta"> ' . __('Posted on', CURRENT_THEME) . '</span> <a href="%s" title="%2$s" rel="bookmark">&nbsp;<time datetime="%3$s">%4$s</time></a><span class = "meta">  ' . __('by ', CURRENT_THEME) . ' </span><a href="%5$s" title="%6$s" rel="author">%7$s</a>',
                        esc_url(get_permalink()),
                        esc_attr(get_the_time()),
                        esc_attr(get_the_date('c')),
                        esc_html(get_the_date()),
                        esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                        sprintf(esc_attr__('View all posts by %s', CURRENT_THEME), get_the_author()),
                        esc_html(get_the_author())
                    );
                } else if ($var_author) {
                    printf('<span class="meta-sep"> ' . __('Posted by', CURRENT_THEME) . '</span> %s  ',
                        sprintf('<span class="author vcard"><a class="url fn n" href="%s" title="%2$s">%3$s</a></span>',
                            get_author_posts_url(get_the_author_meta('ID')),
                            sprintf(esc_attr__('View all posts by %s', CURRENT_THEME), get_the_author()),
                            get_the_author())
                    );
                } else if ($var_date) {
                    printf('<span class="meta">  ' . __('Posted on', CURRENT_THEME) . ' <time datetime="%3$s">%4$s</time></a>',
                        esc_url(get_permalink()),
                        esc_attr(get_the_time()),
                        esc_attr(get_the_date('c')),
                        esc_html(get_the_date())
                    );
                }
            } else {

                if ($var_date && $var_author) {
                    printf('<span class="meta"> ' . __('Posted on', CURRENT_THEME) . '</span> <a href="%s" title="%2$s" rel="bookmark">&nbsp;<time datetime="%3$s">%4$s</time></a><span class = "meta"> ' . __('by ', CURRENT_THEME) . '</span><a href="%5$s" title="%6$s" rel="author">%7$s</a>',
                        esc_url(get_permalink()),
                        esc_attr(get_the_time()),
                        esc_attr(get_the_date('c')),
                        esc_html(get_the_date()),
                        esc_url(get_author_posts_url(get_the_author_meta('ID'))),
                        sprintf(esc_attr__('View all posts by %s', CURRENT_THEME), get_the_author()),
                        esc_html(get_the_author())
                    );
                } else if ($var_author) {
                    printf('<span class="meta-sep"> ' . __('Posted by', CURRENT_THEME) . '</span>  %s  ',
                        sprintf('<span class="author vcard"><a class="url fn n" href="%s" title="%2$s">%3$s</a></span>',
                            get_author_posts_url(get_the_author_meta('ID')),
                            sprintf(esc_attr__('View all posts by %s', CURRENT_THEME), get_the_author()),
                            get_the_author())
                    );
                } else if ($var_date) {
                    printf('<span class="meta"> ' . __('Posted on', CURRENT_THEME) . '<time datetime="%3$s">%4$s</time></a>',
                        esc_url(get_permalink()),
                        esc_attr(get_the_time()),
                        esc_attr(get_the_date('c')),
                        esc_html(get_the_date())
                    );
                }

            }
            echo '</div>';
        endif;
    }
endif;


/**
 * Adds two classes to the array of body classes.
 * The first is if the site has only had one author with published posts.
 * The second is if a singular post being displayed
 */
function templatetoaster_body_classes($classes)
{

    if (!is_multi_author()) {
        $classes[] = 'single-author';
    }

    if (is_singular() && !is_home() && !is_page_template('showcase.php') && !is_page_template('sidebar-page.php'))
        $classes[] = 'singular';

    return $classes;
}

add_filter('body_class', 'templatetoaster_body_classes');


function templatetoaster_theme_nav_menu($templatetoaster_cssprefix, $location, $mmenu, $templatetoaster_magmenu, $templatetoaster_menuh, $templatetoaster_vmenuh, $templatetoaster_ocmenu, $menuname = '')
{
    global $templatetoaster_justify;

    $output = '';
    if ($menuname == '') {
        $locations = get_nav_menu_locations();

        if (empty($locations))
            $menu = NULL;
        else
            $menu = wp_get_nav_menu_object($locations[$location]);
    } else {
        $menu = wp_get_nav_menu_object($menuname);
    }

    if ($menu == NULL) {
        return templatetoaster_generate_menu($templatetoaster_cssprefix, $mmenu, $templatetoaster_magmenu, $templatetoaster_menuh, $templatetoaster_vmenuh, $templatetoaster_ocmenu);
    } else {
        $menu_items = wp_get_nav_menu_items($menu->term_id);
        $count = 0;

        foreach ($menu_items as $key => $menu_item) {
            if ($menu_item->menu_item_parent != 0)
                continue;
            $count++;
        }

        $count1 = 0;

        foreach ($menu_items as $key => $menu_item) {

            $menu_item->classes = empty($menu_item->classes) ? (array)get_post_meta($menu_item->ID, '_menu_item_classes', true) : $menu_item->classes;
            $liclass = $menu_item->classes[0];

            if ($menu_item->menu_item_parent != 0)
                continue;
            $childs = templatetoaster_theme_getsubmenu($menu_items, $menu_item);

            if (!empty($menu_item->url)) {
                $count1++;

                if (empty($childs)) {

                    if (templatetoaster_theme_curPageURL() === $menu_item->url) {
                        $target = $menu_item->target;
                        if (!empty($target)) {
                            $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown active"><a href="' . $menu_item->url . '" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_active" target="' . $menu_item->target . '"><span class="menuchildicon"></span>' . $menu_item->title;
                        } else {
                            $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown active"><a href="' . $menu_item->url . '" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_active"><span class="menuchildicon"></span>' . $menu_item->title;
                        }
                    } else if (function_exists('templatetoaster_woocommerce_get_page_id') && (int)templatetoaster_woocommerce_get_page_id('shop') == $menu_item->object_id && is_shop()) {
                        $shop_page = (int)templatetoaster_woocommerce_get_page_id('shop');
                        if ($shop_page == $menu_item->object_id) {
                            $target = $menu_item->target;
                            if (!empty($target)) {
                                $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown active"><a href="' . $menu_item->url . '" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_active" target="' . $menu_item->target . '"><span class="menuchildicon"></span>' . $menu_item->title;
                            } else {
                                $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown active"><a href="' . $menu_item->url . '" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_active"><span class="menuchildicon"></span>' . $menu_item->title;
                            }

                        }

                    } else {
                        $target = $menu_item->target;
                        if (!empty($target)) {
                            $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown"><a href="' . $menu_item->url . '" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link" target="' . $menu_item->target . '"><span class="menuchildicon"></span>' . $menu_item->title;
                        } else {
                            $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown"><a href="' . $menu_item->url . '" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link"><span class="menuchildicon"></span>' . $menu_item->title;
                        }

                    }

                    if ($count1 != $count) {
                        if ($templatetoaster_justify) {
                            $output .= ('<hr class="horiz_separator" /></a>');
                        } else {
                            $output .= ('</a><hr class="horiz_separator" />');
                        }
                    } else {
                        $output .= ('</a>');
                    }

                    $output .= '</li>';
                } else {

                    if (templatetoaster_theme_curPageURL() === $menu_item->url) {
                        $target = $menu_item->target;
                        if (!empty($target)) {
                            $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown active"><a href="' . $menu_item->url . '" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_active_arrow dropdown-toggle" data-toggle="dropdown" target="' . $menu_item->target . '"><span class="menuchildicon"></span>' . $menu_item->title;
                        } else {
                            $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown active"><a href="' . $menu_item->url . '" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_active_arrow dropdown-toggle" data-toggle="dropdown"><span class="menuchildicon"></span>' . $menu_item->title;
                        }
                    } else if (function_exists('templatetoaster_woocommerce_get_page_id') && (int)templatetoaster_woocommerce_get_page_id('shop') == $menu_item->object_id && is_shop()) {
                        $shop_page = (int)templatetoaster_woocommerce_get_page_id('shop');

                        if ($shop_page == $menu_item->object_id) {
                            $target = $menu_item->target;
                            if (!empty($target)) {
                                $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown active"><a href="' . $menu_item->url . '" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_active_arrow dropdown-toggle" data-toggle="dropdown"  target="' . $menu_item->target . '"><span class="menuchildicon"></span>' . $menu_item->title;
                            } else {
                                $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown active"><a href="' . $menu_item->url . '" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_active_arrow dropdown-toggle" data-toggle="dropdown"><span class="menuchildicon"></span>' . $menu_item->title;
                            }
                        }
                    } else {
                        $target = $menu_item->target;
                        if (!empty($target)) {
                            $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown"><a href="' . $menu_item->url . '" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_arrow dropdown-toggle" data-toggle="dropdown"  target="' . $menu_item->target . '"><span class="menuchildicon"></span>' . $menu_item->title;
                        } else {
                            $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown"><a href="' . $menu_item->url . '" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_arrow dropdown-toggle" data-toggle="dropdown"><span class="menuchildicon"></span>' . $menu_item->title;
                        }
                    }

                    if ($count1 != $count) {
                        if ($templatetoaster_justify) {
                            $output .= ('<hr class="horiz_separator" /></a>');
                        } else {
                            $output .= ('</a><hr class="horiz_separator" />');
                        }
                    } else {
                        $output .= ('</a>');
                    }
                    $output .= templatetoaster_generate_level1_custom_children($menu_items, $childs, $mmenu, $templatetoaster_magmenu, $templatetoaster_menuh, $templatetoaster_vmenuh);
                    $output .= '</li>';
                }

            } else {
                if (empty($childs)) {

                    if (templatetoaster_theme_curPageURL() === $menu_item->url) {
                        $target = $menu_item->target;
                        if (!empty($target)) {
                            $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown active"><a href="javascript:void(0)" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_active" target="' . $menu_item->target . '"><span class="menuchildicon"></span>' . $menu_item->title;
                        } else {
                            $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown active"><a href="javascript:void(0)" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_active"><span class="menuchildicon"></span>' . $menu_item->title;
                        }
                    } else if (function_exists('templatetoaster_woocommerce_get_page_id') && (int)templatetoaster_woocommerce_get_page_id('shop') == $menu_item->object_id && is_shop()) {
                        $shop_page = (int)templatetoaster_woocommerce_get_page_id('shop');
                        if ($shop_page == $menu_item->object_id) {
                            $target = $menu_item->target;
                            if (!empty($target)) {
                                $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown active"><a href="javascript:void(0)" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_active" target="' . $menu_item->target . '"><span class="menuchildicon"></span>' . $menu_item->title;
                            } else {
                                $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown active"><a href="javascript:void(0)" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_active"><span class="menuchildicon"></span>' . $menu_item->title;
                            }

                        }

                    } else {
                        $target = $menu_item->target;
                        if (!empty($target)) {
                            $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown"><a href="javascript:void(0)" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link" target="' . $menu_item->target . '"><span class="menuchildicon"></span>' . $menu_item->title;
                        } else {
                            $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown"><a href="javascript:void(0)" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link"><span class="menuchildicon"></span>' . $menu_item->title;
                        }

                    }

                    if ($count1 != $count) {
                        if ($templatetoaster_justify) {
                            $output .= ('<hr class="horiz_separator" /></a>');
                        } else {
                            $output .= ('</a><hr class="horiz_separator" />');
                        }
                    } else {
                        $output .= ('</a>');
                    }

                    $output .= '</li>';
                } else {
                    if (templatetoaster_theme_curPageURL() === $menu_item->url) {
                        $target = $menu_item->target;
                        if (!empty($target)) {
                            $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown active"><a href="javascript:void(0)" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_active_arrow dropdown-toggle" data-toggle="dropdown" target="' . $menu_item->target . '"><span class="menuchildicon"></span>' . $menu_item->title;
                        } else {
                            $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown active"><a href="javascript:void(0)" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_active_arrow dropdown-toggle" data-toggle="dropdown"><span class="menuchildicon"></span>' . $menu_item->title;
                        }

                    } else if (function_exists('templatetoaster_woocommerce_get_page_id') && (int)templatetoaster_woocommerce_get_page_id('shop') == $menu_item->object_id && is_shop()) {
                        $shop_page = (int)templatetoaster_woocommerce_get_page_id('shop');
                        if ($shop_page == $menu_item->object_id) {
                            $target = $menu_item->target;
                            if (!empty($target)) {
                                $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown active"><a href="javascript:void(0)" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_active_arrow dropdown-toggle" data-toggle="dropdown"  target="' . $menu_item->target . '"><span class="menuchildicon"></span>' . $menu_item->title;
                            } else {
                                $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown active"><a href="javascript:void(0)" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_active_arrow dropdown-toggle" data-toggle="dropdown"><span class="menuchildicon"></span>' . $menu_item->title;
                            }

                        }

                    } else {
                        $target = $menu_item->target;
                        if (!empty($target)) {
                            $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown"><a href="javascript:void(0)" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_arrow dropdown-toggle" data-toggle="dropdown"  target="' . $menu_item->target . '"><span class="menuchildicon"></span>' . $menu_item->title;
                        } else {
                            $output .= '<li class="' . $liclass . " " . $templatetoaster_cssprefix . $mmenu . '_items_parent dropdown"><a href="javascript:void(0)" class="' . $templatetoaster_cssprefix . $mmenu . '_items_parent_link_arrow dropdown-toggle" data-toggle="dropdown"><span class="menuchildicon"></span>' . $menu_item->title;
                        }
                    }

                    if ($count1 != $count) {
                        if ($templatetoaster_justify) {
                            $output .= ('<hr class="horiz_separator" /></a>');
                        } else {
                            $output .= ('</a><hr class="horiz_separator" />');
                        }
                    } else {
                        $output .= ('</a>');
                    }
                    $output .= templatetoaster_generate_level1_custom_children($menu_items, $childs, $mmenu, $templatetoaster_magmenu, $templatetoaster_menuh, $templatetoaster_vmenuh);
                    $output .= '</li>';
                }

            }


        }

        return $output;
    }
}

function templatetoaster_theme_curPageURL()
{
    $pageURL = 'http';
    if (!empty($_SERVER['HTTPS'])) {
        $pageURL .= "s";
    }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    global $post;

    $a = get_permalink($post->ID);
    return $pageURL;
}

function templatetoaster_theme_getsubmenu($menu_items, $parent)
{
    $submenu = array(); // all menu items under $menuID

    foreach ($menu_items as $key => $item) {
        if ($item->menu_item_parent == $parent->ID) {

            $submenu[] = $item;

        }

    }
    return $submenu;
}

function templatetoaster_generate_menu($templatetoaster_cssprefix = "ttr_", $meenu, $templatetoaster_magmenu, $templatetoaster_menuh, $templatetoaster_vmenuh, $templatetoaster_ocmenu)
{
    global $templatetoaster_justify;
    $output = '';
    if (is_front_page()) {
        $output .= '<li class="' . $templatetoaster_cssprefix . $meenu . '_items_parent dropdown active"><a href="' . get_home_url(null, '/') . '" class="' . $templatetoaster_cssprefix . $meenu . '_items_parent_link_active"><span class="menuchildicon"></span>' . __('Home', CURRENT_THEME);

        if ($templatetoaster_justify) {
            $output .= ('<hr class="horiz_separator" /> </a>');

        } else {
            $output .= ('</a><hr class="horiz_separator" />');
        }

        $output .= '</li>';
    } else {
        $output .= '<li class="' . $templatetoaster_cssprefix . $meenu . '_items_parent dropdown"><a href="' . get_home_url(null, '/') . '" class="' . $templatetoaster_cssprefix . $meenu . '_items_parent_link"><span class="menuchildicon"></span>' . __('Home', CURRENT_THEME);

        if ($templatetoaster_justify) {
            $output .= ('<hr class="horiz_separator" /> </a>');

        } else {
            $output .= ('</a><hr class="horiz_separator" />');
        }

        $output .= '</li>';
    }

    $pages = get_pages(array('child_of' => 0, 'hierarchical' => 0, 'parent' => 0, 'sort_column' => 'menu_order,post_title'));

    $count = count($pages);

    $count2 = 0;
    foreach ($pages as $key => $pagg) {
        if ($pagg->post_parent == 0)
            continue;
        $count2++;
    }
    $count1 = 0;

    foreach ($pages as $key => $pagg) {
        $childs = get_pages(array('child_of' => $pagg->ID, 'hierarchical' => 0, 'parent' => $pagg->ID, 'sort_column' => 'menu_order,post_title'));

        $count1++;

        if (empty($childs)) {
            if (home_url() != untrailingslashit(get_permalink($pagg->ID))) {

                if (get_permalink() === get_permalink($pagg->ID)) {
                    $output .= '<li class="' . $templatetoaster_cssprefix . $meenu . '_items_parent dropdown active"><a href="' . get_permalink($pagg->ID) . '" class="' . $templatetoaster_cssprefix . $meenu . '_items_parent_link_active"><span class="menuchildicon"></span>' . $pagg->post_title;

                    if ($count1 != $count2) {
                        if ($templatetoaster_justify) {
                            $output .= ('<hr class="horiz_separator" /> </a>');

                        } else {
                            $output .= ('</a><hr class="horiz_separator" />');
                        }

                    } else {
                        $output .= ('</a>');
                    }

                    $output .= '</li>';
                } else if (function_exists('templatetoaster_woocommerce_get_page_id') && (int)templatetoaster_woocommerce_get_page_id('shop') === $pagg->ID && is_shop()) {
                    $shop_page = (int)templatetoaster_woocommerce_get_page_id('shop');
                    if ($shop_page === $pagg->ID) {
                        $output .= '<li class="' . $templatetoaster_cssprefix . $meenu . '_items_parent dropdown active"><a href="' . get_permalink($pagg->ID) . '" class="' . $templatetoaster_cssprefix . $meenu . '_items_parent_link_active"><span class="menuchildicon"></span>' . $pagg->post_title;

                        if ($count1 != $count2) {
                            if ($templatetoaster_justify) {
                                $output .= ('<hr class="horiz_separator" /> </a>');

                            } else {
                                $output .= ('</a><hr class="horiz_separator" />');
                            }

                        } else {
                            $output .= ('</a>');
                        }

                        $output .= '</li>';
                    }

                } else {
                    $output .= '<li class="' . $templatetoaster_cssprefix . $meenu . '_items_parent dropdown"><a href="' . get_permalink($pagg->ID) . '" class="' . $templatetoaster_cssprefix . $meenu . '_items_parent_link"><span class="menuchildicon"></span>' . $pagg->post_title;

                    if ($count1 != $count2) {
                        if ($templatetoaster_justify) {
                            $output .= ('<hr class="horiz_separator" /> </a>');

                        } else {
                            $output .= ('</a><hr class="horiz_separator" />');
                        }

                    } else {
                        $output .= ('</a>');
                    }

                    $output .= '</li>';
                }
            }
        } else {
            if (home_url() != untrailingslashit(get_permalink($pagg->ID))) {
                if (get_permalink() === get_permalink($pagg->ID)) {
                    $output .= '<li class="' . $templatetoaster_cssprefix . $meenu . '_items_parent dropdown active"><a href="' . get_permalink($pagg->ID) . '" class="' . $templatetoaster_cssprefix . $meenu . '_items_parent_link_active_arrow dropdown-toggle" data-toggle="dropdown" ><span class="menuchildicon"></span>' . $pagg->post_title;
                } else if (function_exists('templatetoaster_woocommerce_get_page_id') && (int)templatetoaster_woocommerce_get_page_id('shop') === $pagg->ID && is_shop()) {
                    $shop_page = (int)templatetoaster_woocommerce_get_page_id('shop');

                    if ($shop_page === $pagg->ID) {
                        $output .= '<li class="' . $templatetoaster_cssprefix . $meenu . '_items_parent dropdown active"><a href="' . get_permalink($pagg->ID) . '" class="' . $templatetoaster_cssprefix . $meenu . '_items_parent_link_active_arrow dropdown-toggle" data-toggle="dropdown" ><span class="menuchildicon"></span>' . $pagg->post_title;
                    }

                } else {
                    $output .= '<li class="' . $templatetoaster_cssprefix . $meenu . '_items_parent dropdown"><a href="' . get_permalink($pagg->ID) . '" class="' . $templatetoaster_cssprefix . $meenu . '_items_parent_link_arrow dropdown-toggle" data-toggle="dropdown" ><span class="menuchildicon"></span>' . $pagg->post_title;
                }
            }

            if ($count1 != $count2) {
                if ($templatetoaster_justify) {
                    $output .= ('<hr class="horiz_separator" /></a>');

                } else {
                    $output .= ('</a><hr class="horiz_separator" />');
                }

            } else {
                $output .= ('</a>');
            }

            $output .= templatetoaster_generate_level1_children($childs, $meenu, $templatetoaster_magmenu, $templatetoaster_menuh, $templatetoaster_vmenuh);
            $output .= '</li>';
        }

    }

    return $output;

}


function templatetoaster_generate_level1_children($args, $mmenu, $templatetoaster_magmenu, $templatetoaster_menuh, $templatetoaster_vmenuh)
{
    $output = '';

    if ('menu' == $mmenu) {
        $output .= '<ul class="child dropdown-menu" role="menu">';
    } else {
        if ($templatetoaster_menuh) {

            $output .= '<ul class="child dropdown-menu" role="menu">';

        } else {

            $output .= '<ul class="child collapse" role="menu">';
        }
    }

    $count = count($args);

    foreach ($args as $key => $child) {
        $child->classes = empty($child->classes) ? (array)get_post_meta($child->ID, '_menu_item_classes', true) : $child->classes;
        $liclass = $child->classes[0];
        $childs = get_pages(array('child_of' => $child->ID, 'hierarchical' => 0, 'parent' => $child->ID, 'sort_column' => 'menu_order,post_title'));
        if (empty($childs)) {
            if ($templatetoaster_magmenu) {
                $target = $child->target;
                if (!empty($target)) {
                    $output .= '<li class="' . $liclass . 'span1 unstyled"><a href="' . get_permalink($child->ID) . '" target="' . $child->target . '"><span class="menuchildicon"></span>' . $child->post_title . '</a>';
                } else {
                    $output .= '<li class="' . $liclass . 'span1 unstyled"><a href="' . get_permalink($child->ID) . '><span class="menuchildicon"></span>' . $child->post_title . '</a>';
                }
            } else {
                $target = $child->target;
                if (!empty($target)) {
                    $output .= '<li><a href="' . get_permalink($child->ID) . '" target="' . $child->target . '"><span class="menuchildicon"></span>' . $child->post_title . '</a>';
                } else {
                    $output .= '<li><a href="' . get_permalink($child->ID) . '><span class="menuchildicon"></span>' . $child->post_title . '</a>';
                }
            }

            if ($templatetoaster_magmenu) {
                $output .= ('<hr class="separator" />');
            } else {
                if ($key != ($count - 1)) {
                    $output .= ('<hr class="separator" />');
                }
            }
            $output .= ('</li>');
        } else {

            if ($templatetoaster_magmenu) {
                $target = $child->target;
                if (!empty($target)) {
                    $output .= '<li class="span1 unstyled dropdown dropdown-submenu">';
                    $output .= '<a class="subchild dropdown-toggle" data-toggle="dropdown" href="' . get_permalink($child->ID) . '" target="' . $child->target . '"><span class="menuchildicon"></span>' . $child->post_title . '</a>';
                } else {
                    $output .= '<li class="span1 unstyled dropdown dropdown-submenu">';
                    $output .= '<a class="subchild dropdown-toggle" data-toggle="dropdown" href="' . get_permalink($child->ID) . '><span class="menuchildicon"></span>' . $child->post_title . '</a>';
                }

                if ($templatetoaster_magmenu) {
                    $output .= ('<hr class="separator" />');
                } else {
                    if ($key != ($count - 1)) {
                        $output .= ('<hr class="separator" />');
                    }
                }

            } else {
                $target = $child->target;
                if (!empty($target)) {
                    $output .= '<li class="' . $liclass . 'dropdown dropdown-submenu"><a class="subchild dropdown-toggle" data-toggle="dropdown" href="' . get_permalink($child->ID) . '" target="' . $child->target . '"><span class="menuchildicon"></span>' . $child->post_title . '</a>';

                } else {
                    $output .= '<li class="' . $liclass . 'dropdown dropdown-submenu"><a class="subchild dropdown-toggle" data-toggle="dropdown" href="' . get_permalink($child->ID) . '><span class="menuchildicon"></span>' . $child->post_title . '</a>';
                }

                if ($templatetoaster_magmenu) {
                    $output .= ('<hr class="separator" />');
                } else {
                    if ($key != ($count - 1)) {
                        $output .= ('<hr class="separator" />');
                    }
                }
            }

            if ($templatetoaster_magmenu) {
                $output .= templatetoaster_generate_level2_children($childs, $mmenu, $templatetoaster_magmenu, $templatetoaster_menuh, $templatetoaster_vmenuh);
                $output .= '</li>';
            } else {
                $output .= templatetoaster_generate_level2_children($childs, $mmenu, $templatetoaster_magmenu, $templatetoaster_menuh, $templatetoaster_vmenuh);
                $output .= '</li>';
            }

        }
    }

    $output .= '</ul>';
    return $output;
}

function templatetoaster_generate_level2_children($args, $mmenu, $templatetoaster_magmenu, $templatetoaster_menuh, $templatetoaster_vmenuh)
{
    $output = '';

    if ('menu' == $mmenu) {
        if ($templatetoaster_magmenu) {
            $output .= '<ul role="menu">';
        } elseif ($templatetoaster_menuh) {
            $output .= '<ul class="sub-menu" role="menu">';
        } else {

            $output .= '<ul class="dropdown-menu sub-menu" role="menu">';
        }

    } else {
        if ($templatetoaster_magmenu) {
            $output .= '<ul role="menu">';
        } elseif ($templatetoaster_menuh) {
            if ($templatetoaster_vmenuh) {
                $output .= '<ul class="sub-menu" role="menu">';
            } else {

                $output .= '<ul class="dropdown-menu sub-menu">';
            }
        } else {
            $output .= '<ul class="sub-menu" role="menu">';
        }

    }

    $count = count($args);
    foreach ($args as $key => $child) {
        $child->classes = empty($child->classes) ? (array)get_post_meta($child->ID, '_menu_item_classes', true) : $child->classes;
        $liclass = $child->classes[0];
        $childs = get_pages(array('child_of' => $child->ID, 'hierarchical' => 0, 'parent' => $child->ID, 'sort_column' => 'menu_order,post_title'));
        if (empty($childs)) {
            $target = $child->target;
            if (!empty($target)) {
                $output .= '<li class="' . $liclass . '"><a href="' . get_permalink($child->ID) . '" target="' . $child->target . '"><span class="menuchildicon"></span>' . $child->post_title . '</a>';
            } else {
                $output .= '<li class="' . $liclass . '"><a href="' . get_permalink($child->ID) . '><span class="menuchildicon"></span>' . $child->post_title . '</a>';
            }


            if ($templatetoaster_magmenu) {
                $output .= ('<hr class="separator" />');
            } else {
                if ($key != ($count - 1)) {
                    $output .= ('<hr class="separator" />');
                }
            }
            $output .= '</li>';
        } else {
            $target = $child->target;
            if (!empty($target)) {
                $output .= '<li class=" dropdown dropdown-submenu ' . $liclass . '"><a class="subchild dropdown-toggle" data-toggle="dropdown" href="' . get_permalink($child->ID) . '" target="' . $child->target . '"><span class="menuchildicon"></span>' . $child->post_title . '</a>';
            } else {
                $output .= '<li class=" dropdown dropdown-submenu ' . $liclass . '"><a class="subchild dropdown-toggle" data-toggle="dropdown" href="' . get_permalink($child->ID) . '><span class="menuchildicon"></span>' . $child->post_title . '</a>';
            }


            if ($templatetoaster_magmenu) {
                $output .= ('<hr class="separator" />');
            } else {
                if ($key != ($count - 1)) {
                    $output .= ('<hr class="separator" />');
                }
            }
            $output .= templatetoaster_generate_level2_children($childs, $mmenu, $templatetoaster_magmenu, $templatetoaster_menuh, $templatetoaster_vmenuh);
            $output .= '</li>';
        }
    }
    $output .= '</ul>';
    return $output;
}


function templatetoaster_generate_level1_custom_children($menu_items, $args, $mmenu, $templatetoaster_magmenu, $templatetoaster_menuh, $templatetoaster_vmenuh)
{
    $output = '';

    if ('menu' == $mmenu) {
        $output .= '<ul class="child dropdown-menu" role="menu">';
    } else {
        if ($templatetoaster_menuh) {

            $output .= '<ul class="child dropdown-menu" role="menu">';

        } else {

            $output .= '<ul class="child collapse" role="menu">';

        }

    }
    $count = count($args);

    foreach ($args as $key => $child) {
        $child->classes = empty($child->classes) ? (array)get_post_meta($child->ID, '_menu_item_classes', true) : $child->classes;
        $liclass = $child->classes[0];
        $childs = templatetoaster_theme_getsubmenu($menu_items, $child);
        if (empty($childs)) {
            if ($templatetoaster_magmenu) {
                $target = $child->target;
                if (!empty($target)) {
                    $output .= '<li class="' . $liclass . 'span1 unstyled"><a href="' . $child->url . '" target="' . $child->target . '"><span class="menuchildicon"></span>' . $child->title . '</a>';
                } else {
                    $output .= '<li class="' . $liclass . 'span1 unstyled"><a href="' . $child->url . '><span class="menuchildicon"></span>' . $child->title . '</a>';
                }
            } else {
                $target = $child->target;
                if (!empty($target)) {
                    $output .= '<li><a href="' . $child->url . '" target="' . $child->target . '"><span class="menuchildicon"></span>' . $child->title . '</a>';
                } else {
                    $output .= '<li><a href="' . $child->url . '"><span class="menuchildicon"></span>' . $child->title . '</a>';
                }


            }
            if ($templatetoaster_magmenu) {
                $output .= ('<hr class="separator" />');
            } else {
                if ($key != ($count - 1)) {
                    $output .= ('<hr class="separator" />');
                }
            }
            $output .= '</li>';

        } else {

            if ($templatetoaster_magmenu) {
                $target = $child->target;
                if (!empty($target)) {
                    $output .= '<li class="span1 unstyled dropdown dropdown-submenu">';
                    $output .= '<a class="subchild dropdown-toggle" data-toggle="dropdown" href="' . $child->url . '" target="' . $child->target . '"><span class="menuchildicon"></span>' . $child->title . '</a>';
                } else {
                    $output .= '<li class="span1 unstyled dropdown dropdown-submenu">';
                    $output .= '<a class="subchild dropdown-toggle" data-toggle="dropdown" href="' . $child->url . '"><span class="menuchildicon"></span>' . $child->title . '</a>';
                }
                if ($templatetoaster_magmenu) {
                    $output .= ('<hr class="separator" />');
                } else {
                    if ($key != ($count - 1)) {
                        $output .= ('<hr class="separator" />');
                    }
                }
            } else {
                $target = $child->target;
                if (!empty($target)) {
                    $output .= '<li class="' . $liclass . 'dropdown dropdown-submenu"><a class="subchild dropdown-toggle" data-toggle="dropdown" href="' . $child->url . '" target="' . $child->target . '"><span class="menuchildicon"></span>' . $child->title . '</a>';
                } else {
                    $output .= '<li class="' . $liclass . 'dropdown dropdown-submenu"><a class="subchild dropdown-toggle" data-toggle="dropdown" href="' . $child->url . '"><span class="menuchildicon"></span>' . $child->title . '</a>';
                }
                if ($templatetoaster_magmenu) {
                    $output .= ('<hr class="separator" />');
                } else {
                    if ($key != ($count - 1)) {
                        $output .= ('<hr class="separator" />');
                    }
                }

            }
            if ($templatetoaster_magmenu) {
                $output .= templatetoaster_generate_level2_custom_children($menu_items, $childs, $mmenu, $templatetoaster_magmenu, $templatetoaster_menuh, $templatetoaster_vmenuh);
                $output .= '</li>';
            } else {
                $output .= templatetoaster_generate_level2_custom_children($menu_items, $childs, $mmenu, $templatetoaster_magmenu, $templatetoaster_menuh, $templatetoaster_vmenuh);
                $output .= '</li>';
            }

        }

    }

    $output .= '</ul>';
    return $output;
}

function templatetoaster_generate_level2_custom_children($menu_items, $args, $mmenu, $templatetoaster_magmenu, $templatetoaster_menuh, $templatetoaster_vmenuh)
{
    $output = '';
    $count = count($args);

    if ('menu' == $mmenu) {
        if ($templatetoaster_magmenu) {
            $output .= '<ul role="menu">';
        } elseif ($templatetoaster_menuh) {
            $output .= '<ul class="sub-menu" role="menu">';
        } else {

            $output .= '<ul class="dropdown-menu sub-menu" role="menu">';
        }

    } else {
        if ($templatetoaster_magmenu) {
            $output .= '<ul role="menu">';
        } elseif ($templatetoaster_menuh) {
            if ($templatetoaster_vmenuh) {
                $output .= '<ul class="sub-menu" role="menu">';
            } else {
                $output .= '<ul class="dropdown-menu sub-menu">';
            }
        } else {
            $output .= '<ul class="sub-menu dropdown-menu" role="menu">';
        }

    }

    foreach ($args as $key => $child) {
        $child->classes = empty($child->classes) ? (array)get_post_meta($child->ID, '_menu_item_classes', true) : $child->classes;
        $liclass = $child->classes[0];
        $childs = templatetoaster_theme_getsubmenu($menu_items, $child);
        if (empty($childs)) {
            $target = $child->target;
            if (!empty($target)) {
                $output .= '<li class="' . $liclass . '"><a href="' . $child->url . '" target="' . $child->target . '"><span class="menuchildicon"></span>' . $child->title . '</a>';
            } else {
                $output .= '<li class="' . $liclass . '"><a href="' . $child->url . '"><span class="menuchildicon"></span>' . $child->title . '</a>';
            }

            if ($templatetoaster_magmenu) {
                $output .= ('<hr class="separator" />');
            } else {
                if ($key != ($count - 1)) {
                    $output .= ('<hr class="separator" />');
                }
            }
            $output .= '</li>';
        } else {
            $target = $child->target;
            if (!empty($target)) {
                $output .= '<li class=" dropdown dropdown-submenu ' . $liclass . '"><a class="subchild dropdown-toggle" data-toggle="dropdown" href="' . $child->url . '"  target="' . $child->target . '"><span class="menuchildicon"></span>' . $child->title . '</a>';
            } else {
                $output .= '<li class=" dropdown dropdown-submenu ' . $liclass . '"><a class="subchild dropdown-toggle" data-toggle="dropdown" href="' . $child->url . '"><span class="menuchildicon"></span>' . $child->title . '</a>';
            }

            if ($templatetoaster_magmenu) {
                $output .= ('<hr class="separator" />');
            } else {
                if ($key != ($count - 1)) {
                    $output .= ('<hr class="separator" />');
                }
            }
            $output .= templatetoaster_generate_level2_custom_children($menu_items, $childs, $mmenu, $templatetoaster_magmenu, $templatetoaster_menuh, $templatetoaster_vmenuh);
            $output .= '</li>';
        }
    }
    $output .= '</ul>';
    return $output;
}


/**
 * Prints HTML with meta information for the current post-date/time and author.
 * Create your own templatetoaster_posted_on to override in a child theme
 */

function templatetoaster_theme_dynamic_sidebar($index)
{
    global $wp_registered_sidebars, $wp_registered_widgets, $templatetoaster_cssprefix, $params, $menuclass;
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

    if (is_int($index)) {
        $index = "sidebar-$index";
        $i = 0;
    } else {
        $i = 0;
        $index = sanitize_title($index);
        foreach ((array)$wp_registered_sidebars as $key => $value) {
            if (sanitize_title($value['name']) == $index) {
                $index = $key;
                break;
            }
        }
    }

    $templatetoaster_sidebars_widgets = wp_get_sidebars_widgets();
    if (empty($templatetoaster_sidebars_widgets))
        return false;


    if (empty($wp_registered_sidebars[$index]) || !array_key_exists($index, $templatetoaster_sidebars_widgets) || !is_array($templatetoaster_sidebars_widgets[$index]) || empty($templatetoaster_sidebars_widgets[$index]))
        return false;

    $sidebar = $wp_registered_sidebars[$index];

    ob_start();
    if (!dynamic_sidebar($index)) {
        return FALSE;
    }
    $sidebarcontent = ob_get_clean();

    $data = explode("~tt", $sidebarcontent);

    foreach ((array)$templatetoaster_sidebars_widgets[$index] as $id) {
        $params = array_merge(
            array(array_merge((array)$sidebar, array('widget_id' => $id, 'widget_name' => $wp_registered_widgets[$id]['name']))),
            (array)$wp_registered_widgets[$id]['params']);
        if (!isset($data[$i])) {
            continue;
        }

        $classname_ = '';
        foreach ((array)$wp_registered_widgets[$id]['classname'] as $cn) {
            if (is_string($cn))
                $classname_ .= '_' . $cn;
            elseif (is_object($cn))
                $classname_ .= '_' . get_class($cn);
        }
        $classname_ = ltrim($classname_, '_');
        $params[0]['before_widget'] = sprintf($params[0]['before_widget'], $id, $classname_);
        $params = apply_filters('dynamic_sidebar_params', $params);

        $widget = $data[$i];

        $i++;
        if (!is_string($widget) || strlen(str_replace(array('&nbsp;', ' ', "\n", "\r", "\t"), '', $widget)) == 0) continue;
        if (strlen(str_replace(array('&nbsp;', ' ', "\n", "\r", "\t"), '', $params[0]['before_title'])) == 0) {
            $widget = preg_replace('#(\'\').*?(' . $params[0]['after_title'] . ')#', '$1$2', $widget);
        }

        $pos = strpos($widget, $params[0]['after_title']);

        $widget_id = $params[0]['widget_id'];

        $widget_obj = $wp_registered_widgets[$widget_id];

        $widget_opt = get_option($widget_obj['callback'][0]->option_name);

        $widget_num = $widget_obj['params'][0]['number'];

        if (isset($widget_opt[$widget_num]['style'])) {
            $style = $widget_opt[$widget_num]['style'];
        } else
            $style = '';

        if ($style == "block") {
            if ($pos === FALSE) {

                $widget = str_replace($params[0]['before_widget'], '<div class = "' . $templatetoaster_cssprefix . 'block"> <div class="remove_collapsing_margins"></div>
			<div class = "' . $templatetoaster_cssprefix . 'block_without_header"> </div> <div id="' . $widget_id . '" class="' . $templatetoaster_cssprefix . 'block_content">', $widget);
            } else {
                $widget = str_replace($params[0]['before_widget'], '<div class="' . $templatetoaster_cssprefix . 'block"><div class="remove_collapsing_margins"></div> <div class="' . $templatetoaster_cssprefix . 'block_header">', $widget);
            }
            $params[0]['after_widget'] = str_replace('~tt', '', $params[0]['after_widget']);
            $widget = str_replace($params[0]['after_widget'], '</div></div>', $widget);
            $widget = str_replace($params[0]['after_title'], '</' . $heading_tag . '></div> <div id="' . $widget_id . '" class="' . $templatetoaster_cssprefix . 'block_content">', $widget);
            $widget = str_replace($params[0]['before_title'], '<' . $heading_tag . ' style="font-size:' . templatetoaster_theme_option('ttr_font_size_block') . 'px;" class="' . $templatetoaster_cssprefix . 'block_heading">', $widget);
        } else if ($style == "none") {
            $classname_ = '';
            foreach ((array)$wp_registered_widgets[$id]['classname'] as $cn) {
                if (is_string($cn))
                    $classname_ .= '_' . $cn;
                elseif (is_object($cn))
                    $classname_ .= '_' . get_class($cn);
            }
            $classname_ = ltrim($classname_, '_');
            $widget = str_replace($params[0]['before_widget'], sprintf('<aside id="%s" class="widget %2$s">', $id, $classname_), $widget);
            $params[0]['after_widget'] = str_replace('~tt', '', $params[0]['after_widget']);
            $widget = str_replace($params[0]['after_widget'], '</aside>', $widget);
            $widget = str_replace($params[0]['after_title'], '</h3>', $widget);
            $widget = str_replace($params[0]['before_title'], '<h3 class="widget-title">', $widget);
        } else {
            if ($index == 'sidebar-1' || $index == 'sidebar-2') {

                if ($pos === FALSE) {

                    $widget = str_replace($params[0]['before_widget'], '<div class = "' . $templatetoaster_cssprefix . 'block"> <div class="remove_collapsing_margins"></div>
			<div class = "' . $templatetoaster_cssprefix . 'block_without_header"> </div> <div id="' . $widget_id . '" class="' . $templatetoaster_cssprefix . 'block_content">', $widget);
                }
            }
        }

        echo $widget;

    }
    return true;
}

function templatetoaster_theme_comment_form($args = array(), $post_id = null, $templatetoaster_cssprefix = "ttr_")
{
    global $user_identity, $id;

    if (null === $post_id)
        $post_id = $id;
    else
        $id = $post_id;

    $commenter = wp_get_current_commenter();

    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');
    $fields = array(
        'author' => '<p class="comment-form-author">' . '<label for="author">' . __('Name', CURRENT_THEME) . '</label> ' . ($req ? '<span class="required">*</span>' : '') . '<br/>' .
            '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>',
        'email' => '<p class="comment-form-email"><label for="email">' . __('Email', CURRENT_THEME) . '</label> ' . ($req ? '<span class="required">*</span>' : '') . '<br/>' .
            '<input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p>',
        'url' => '<p class="comment-form-url"><label for="url">' . __('Website', CURRENT_THEME) . '</label>' . '<br/>' .
            '<input id="url" name="url" type="text" value="' . esc_attr($commenter['comment_author_url']) . '" size="30" /></p>',
    );

    $required_text = sprintf(' ' . __('Required fields are marked %s', CURRENT_THEME), '<span class="required">*</span>');
    $defaults = array(
        'fields' => apply_filters('comment_form_default_fields', $fields),
        'comment_field' => '<p class="comment-form-comment"><label for="comment">' . _x('Comment', 'noun', CURRENT_THEME) . '</label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>' . '<br/>',
        'must_log_in' => '<p class="must-log-in">' . sprintf(__('You must be <a href="%s">logged in</a> to post a comment.', CURRENT_THEME), wp_login_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>',
        'logged_in_as' => '<p class="logged-in-as">' . sprintf(__('Logged in as <a href="%s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', CURRENT_THEME), admin_url('profile.php'), $user_identity, wp_logout_url(apply_filters('the_permalink', get_permalink($post_id)))) . '</p>',
        'comment_notes_before' => '<p class="comment-notes">' . __('Your email address will not be published.', CURRENT_THEME) . ($req ? $required_text : '') . '</p>',
        'comment_notes_after' => '<p class="form-allowed-tags">' . sprintf(__('You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', CURRENT_THEME), ' <code>' . allowed_tags() . '</code>') . '</p>',
        'id_form' => 'commentform',
        'id_submit' => 'submit',
        'title_reply' => __('Leave a Reply', CURRENT_THEME),
        'title_reply_to' => __('Leave a Reply to %s', CURRENT_THEME),
        'cancel_reply_link' => __('Cancel reply', CURRENT_THEME),
        'label_submit' => __('Post Comment', CURRENT_THEME),
    );

    $args = wp_parse_args($args, apply_filters('comment_form_defaults', $defaults));

    ?>
    <?php if (comments_open()) : ?>
    <?php do_action('comment_form_before'); ?>

    <!--<div id="respond">-->
    <?php if (templatetoaster_theme_option('ttr_comments_form')): ?>
        <div class="<?php echo esc_attr($templatetoaster_cssprefix); ?>comment">
            <div class="<?php echo esc_attr($templatetoaster_cssprefix); ?>comment_header">
                <div class="<?php echo esc_attr($templatetoaster_cssprefix); ?>comment_header_left_border_image">
                    <div class="<?php echo esc_attr($templatetoaster_cssprefix); ?>comment_header_right_border_image">
                    </div>
                </div>
            </div>
            <div class="<?php echo esc_attr($templatetoaster_cssprefix); ?>comment_content">
                <div class="<?php echo esc_attr($templatetoaster_cssprefix); ?>comment_content_left_border_image">
                    <div class="<?php echo esc_attr($templatetoaster_cssprefix); ?>comment_content_right_border_image">

                        <div class="<?php echo esc_attr($templatetoaster_cssprefix); ?>comment_content_inner">


                            <h3 id="reply-title"><?php comment_form_title($args['title_reply'], $args['title_reply_to']); ?>
                                <small><?php cancel_comment_reply_link($args['cancel_reply_link']); ?></small>
                            </h3>
                            <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
                                <?php echo $args['must_log_in']; ?>
                                <?php do_action('comment_form_must_log_in_after'); ?>
                            <?php else : ?>
                                <form action="<?php echo esc_url(site_url('/wp-comments-post.php')); ?>" method="post"
                                      id="<?php echo esc_attr($args['id_form']); ?>">
                                    <?php do_action('comment_form_top'); ?>
                                    <?php if (is_user_logged_in()) : ?>
                                        <?php echo apply_filters('comment_form_logged_in', $args['logged_in_as'], $commenter, $user_identity); ?>
                                        <?php do_action('comment_form_logged_in_after', $commenter, $user_identity); ?>
                                    <?php else : ?>
                                        <?php echo $args['comment_notes_before']; ?>
                                        <?php
                                        do_action('comment_form_before_fields');
                                        foreach ((array)$args['fields'] as $name => $field) {
                                            echo apply_filters("comment_form_field_{$name}", $field) . "\n";
                                        }
                                        do_action('comment_form_after_fields');
                                        ?>
                                    <?php endif; ?>
                                    <?php echo apply_filters('comment_form_field_comment', $args['comment_field']); ?>
                                    <?php echo $args['comment_notes_after']; ?>
                                    <div class="form-submit">
						<span class="<?php echo esc_attr($templatetoaster_cssprefix); ?>button"
                              onmouseover="this.className='<?php echo esc_attr($templatetoaster_cssprefix); ?>button_hover1';"
                              onmouseout="this.className='<?php echo esc_attr($templatetoaster_cssprefix); ?>button';">

							<input name="submit" class="btn btn-default" type="submit"
                                   id="<?php echo esc_attr($args['id_submit']); ?>"
                                   value="<?php echo esc_attr($args['label_submit']); ?>"/>
							</span>

                                        <div class="clearfix"></div>
                                        <?php comment_id_fields($post_id); ?>
                                    </div>
                                    <?php do_action('comment_form', $post_id); ?>
                                </form>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
            </div>
            <div class="<?php echo esc_attr($templatetoaster_cssprefix); ?>comment_footer">
                <div class="<?php echo esc_attr($templatetoaster_cssprefix); ?>comment_footer_left_border_image">
                    <div class="<?php echo esc_attr($templatetoaster_cssprefix); ?>comment_footer_right_border_image">
                    </div>
                </div>
            </div>

            <!-- #respond -->
        </div>
    <?php endif; ?>
    <?php do_action('comment_form_after'); ?>
<?php else : ?>
    <?php do_action('comment_form_comments_closed'); ?>
<?php endif; ?>
<?php
}

function templatetoaster_count_sidebar_widgets($sidebar_id)
{
    $the_sidebars = wp_get_sidebars_widgets();
    if (!isset($the_sidebars[$sidebar_id]))
        return FALSE;
    else
        return count($the_sidebars[$sidebar_id]);
}

function templatetoaster_add_init()
{
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_style('jquery-ui',
        'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/themes/smoothness/jquery-ui.css',
        false,
        '1.8.9',
        false);
    wp_enqueue_style('theme-admin', get_template_directory_uri() . '/css/theme-admin.css', array(), '1.0.0');
    $screen = get_current_screen();
    if ($screen->id == 'appearance_page_mytheme-options') {
        wp_enqueue_style('thickbox');
        wp_register_script('upload', get_template_directory_uri() . '/js/upload.js', array('jquery', 'media-upload'));
        wp_enqueue_script('upload');
        wp_register_script('addtextbox', get_template_directory_uri() . '/js/addtextbox.js', array(), 1.0, false);
        wp_enqueue_script('addtextbox', get_template_directory_uri() . '/js/addtextbox.js', array(), 1.0, false);

    }
}

add_action('admin_enqueue_scripts', 'templatetoaster_add_init');

function templatetoaster_options_setup()
{
    global $pagenow;

    if ('media-upload.php' == $pagenow || 'async-upload.php' == $pagenow) {
        // Now we'll replace the 'Insert into Post Button' inside Thickbox
        add_filter('gettext', 'templatetoaster_replace_thickbox_text', 1, 3);
    }
}

add_action('admin_init', 'templatetoaster_options_setup');

function templatetoaster_replace_thickbox_text($translated_text, $text, $domain)
{
    if ('Insert into Post' == $text) {
        $referer = strpos(wp_get_referer(), 'functions.php');
        if ($referer != '') {
            return __('Select this image!', CURRENT_THEME);
        }
    }
    return $translated_text;
}


function templatetoaster_customAdmin()
{

    $screen = get_current_screen();

    wp_register_script('togglebutton', get_template_directory_uri() . '/js/jquery.toggle.buttons.js', array('jquery'), '2.8.2', false);
    wp_enqueue_script('togglebutton');
    wp_register_script('expand', get_template_directory_uri() . '/js/expand.js', array('jquery'), '1.0.0', false);
    wp_enqueue_script('expand');
    wp_register_script('widgetform', get_template_directory_uri() . '/js/widgetform.js', array('jquery'), '1.0.0', false);
    wp_enqueue_script('widgetform');

    wp_enqueue_script('toggleButtons', get_template_directory_uri() . '/js/toggleButtons.js', array('jquery'), '1.0.0', false);
    $passed_data = array('on' => __('ON', CURRENT_THEME), 'off' => __('OFF', CURRENT_THEME));
    wp_localize_script('toggleButtons', 'passed_data', $passed_data);
    wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap-admin.css');
    wp_enqueue_style('bootstrap');
    wp_register_style('bootstrap-toggle-buttons', get_template_directory_uri() . '/css/bootstrap-toggle-buttons.css');
    wp_enqueue_style('bootstrap-toggle-buttons');

}

add_action('admin_head', 'templatetoaster_customAdmin');

function templatetoaster_enqueue_custom_scripts()
{

    wp_register_script('bootstrapfront', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), '3.2.0', true);
    wp_enqueue_script('bootstrapfront');
    wp_register_script('html5shiv', get_template_directory_uri() . '/js/html5shiv.js', array('jquery'), false, true);
    wp_enqueue_script('html5shiv');
    wp_register_script('prefixfree', get_template_directory_uri() . '/js/prefixfree.js', array('jquery'), '1.0.7', true);
    wp_enqueue_script('prefixfree');
    wp_register_script('customscripts', get_template_directory_uri() . '/js/customscripts.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('customscripts');

    wp_register_script('totop', get_template_directory_uri() . '/js/totop.js', array('jquery'), '1.0.0', true);
    wp_enqueue_script('totop');

    wp_enqueue_style('menuie', get_stylesheet_directory_uri() . '/menuie.css');
    wp_style_add_data('menuie', 'conditional', 'if lte IE 8');

    wp_enqueue_style('vmenuie', get_stylesheet_directory_uri() . '/vmenuie.css');
    wp_style_add_data('vmenuie', 'conditional', 'if lte IE 8');

    if (is_rtl()) {
        wp_register_style('rtl', get_stylesheet_directory_uri() . '/rtl.css');
        wp_enqueue_style('rtl', get_stylesheet_directory_uri() . '/rtl.css');
    }
    wp_register_style('bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.css');
    wp_register_style('style', get_stylesheet_directory_uri() . '/style.css');
    wp_register_style('redskin', get_stylesheet_directory_uri() . '/css/red.css');
    wp_register_style('skyblueskin', get_stylesheet_directory_uri() . '/css/skyblue.css');
    wp_register_style('pinkskin', get_stylesheet_directory_uri() . '/css/pink.css');
    wp_register_style('seagreenskin', get_stylesheet_directory_uri() . '/css/seagreen.css');
    wp_register_style('greenskin', get_stylesheet_directory_uri() . '/css/green.css');
    wp_register_style('redbootstrap', get_stylesheet_directory_uri() . '/css/redbootstrap.css');
    wp_register_style('skybluebootstrap', get_stylesheet_directory_uri() . '/css/skybluebootstrap.css');
    wp_register_style('pinkbootstrap', get_stylesheet_directory_uri() . '/css/pinkbootstrap.css');
    wp_register_style('seagreenbootstrap', get_stylesheet_directory_uri() . '/css/seagreenbootstrap.css');
    wp_register_style('greenbootstrap', get_stylesheet_directory_uri() . '/css/greenbootstrap.css');
    wp_register_style('woocommerce', get_stylesheet_directory_uri() . '/css/woocommercestyle.css');
    wp_enqueue_style('woocommerce', get_stylesheet_directory_uri() . '/css/woocommercestyle.css');
    $templatetoaster_skin = templatetoaster_theme_option('ttr_colorscheme');
    switch ($templatetoaster_skin) {
        case 'choice1':
            wp_enqueue_style('bootstrap');
            wp_enqueue_style('style');
            break;
        case 'choice2':
            wp_enqueue_style('redbootstrap');
            wp_enqueue_style('redskin');
            break;
        case 'choice3':
            wp_enqueue_style('skybluebootstrap');
            wp_enqueue_style('skyblueskin');
            break;
        case 'choice4':
            wp_enqueue_style('pinkbootstrap');
            wp_enqueue_style('pinkskin');
            break;
        case 'choice5':
            wp_enqueue_style('seagreenbootstrap');
            wp_enqueue_style('seagreenskin');
            break;
        case 'choice6':
            wp_enqueue_style('greenbootstrap');
            wp_enqueue_style('greenskin');
            break;
        default:
            wp_enqueue_style('bootstrap');
            wp_enqueue_style('style');
            break;
    }
}

add_action('wp_enqueue_scripts', 'templatetoaster_enqueue_custom_scripts');


function templatetoaster_wordpress_breadcrumbs()
{

    $delimiter = templatetoaster_theme_option('ttr_breadcrumb_text_separator');
    $name = __('Home', CURRENT_THEME); //text for the 'Home' link
    $currentBefore = '<span class="current">';
    $currentAfter = '</span>';

    if (!is_home() && !is_front_page() || is_paged()) {

        echo '<div class="breadcrumb">';

        global $post;
        $home = home_url();
        echo templatetoaster_theme_option('ttr_breadcrumb_text');
        echo '<a href="' . $home . '">' . $name . '</a> ' . '<span class="separator">' . $delimiter . '</span>  ';

        if (is_category()) {
            global $wp_query;
            $cat_obj = $wp_query->get_queried_object();
            $thisCat = $cat_obj->term_id;
            $thisCat = get_category($thisCat);
            $parentCat = get_category($thisCat->parent);
            if ($thisCat->parent != 0) echo(get_category_parents($parentCat, TRUE, '<span class="separator"> ' . $delimiter . '</span> '));
            echo $currentBefore . __('Archive by category &#39;', CURRENT_THEME);
            single_cat_title();
            echo '&#39;' . $currentAfter;

        } elseif (is_day()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> <span class="separator">' . $delimiter . '</span> ';
            echo '<a href="' . get_month_link(get_the_time('Y'), get_the_time('m')) . '">' . get_the_time('F') . '</a> <span class="separator">' . $delimiter . '</span> ';
            echo $currentBefore . get_the_time('d') . $currentAfter;

        } elseif (is_month()) {
            echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> <span class="separator">' . $delimiter . '</span> ';
            echo $currentBefore . get_the_time('F') . $currentAfter;

        } elseif (is_year()) {
            echo $currentBefore . get_the_time('Y') . $currentAfter;

        } elseif (is_single()) {
            $cat = get_the_category();
            if (isset($cat) && !empty($cat)) {
                $cat = $cat[0];
                echo get_category_parents($cat, TRUE, ' <span class="separator">' . $delimiter . '</span> ');
                echo $currentBefore;
                the_title();
                echo $currentAfter;
            }

        } elseif (is_page() && !$post->post_parent) {
            echo $currentBefore;
            the_title();
            echo $currentAfter;

        } elseif (is_page() && $post->post_parent) {
            $parent_id = $post->post_parent;
            $breadcrumbs = array();
            while ($parent_id) {
                $page = get_page($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
                $parent_id = $page->post_parent;
            }
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) echo $crumb . '<span class="separator"> ' . $delimiter . '</span> ';
            echo $currentBefore;
            the_title();
            echo $currentAfter;

        } elseif (is_search()) {
            echo $currentBefore . __('Search results for &#39;', CURRENT_THEME) . get_search_query() . '&#39;' . $currentAfter;

        } elseif (is_tag()) {
            echo $currentBefore . __('Posts tagged &#39;', CURRENT_THEME);
            single_tag_title();
            echo '&#39;' . $currentAfter;

        } elseif (is_author()) {
            global $author;
            $userdata = get_userdata($author);
            echo $currentBefore . __('Articles posted by', CURRENT_THEME) . $userdata->display_name . $currentAfter;

        } elseif (is_404()) {
            echo $currentBefore . __('Error 404', CURRENT_THEME) . $currentAfter;
        }

        if (get_query_var('paged')) {
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ' (';
            echo __('Page', CURRENT_THEME) . ' ' . get_query_var('paged');
            if (is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author()) echo ')';
        }

        echo '</div>';

    }
}

add_filter('sidebars_widgets', 'templatetoaster_sidebars_widgets');
//Add input fields(priority 5, 3 parameters)
add_action('in_widget_form', 'templatetoaster_in_widget_form', 5, 3);
//Callback function for options update (priority 5, 3 parameters)
add_filter('widget_update_callback', 'templatetoaster_in_widget_form_update', 5, 3);
function templatetoaster_sidebars_widgets($sidebars)
{
    if (is_admin()) {
        return $sidebars;
    }

    global $wp_registered_widgets;

    foreach ($sidebars as $s => $sidebar) {
        if ($s == 'wp_inactive_widgets' || strpos($s, 'orphaned_widgets') === 0 || empty($sidebar)) {
            continue;
        }

        foreach ($sidebar as $w => $widget) {
            // $widget is the id of the widget
            if (!isset($wp_registered_widgets[$widget])) {
                continue;
            }

            $opts = $wp_registered_widgets[$widget];
            $id_base = is_array($opts['callback']) ? $opts['callback'][0]->id_base : $opts['callback'];

            if (!$id_base) {
                continue;
            }

            $instance = get_option('widget_' . $id_base);

            if (!$instance || !is_array($instance)) {
                continue;
            }

            if (isset($instance['_multiwidget']) && $instance['_multiwidget']) {
                $number = $opts['params'][0]['number'];
                if (!isset($instance[$number])) {
                    continue;
                }

                $instance = $instance[$number];
                unset($number);
            }

            unset($opts);

            $show = templatetoaster_show_widget($instance);


            if (!$show) {
                unset($sidebars[$s][$w]);
            }

            unset($widget);
        }
        unset($sidebar);
    }

    return $sidebars;
}

function templatetoaster_show_widget($instance)
{
    global $wp_query;
    $post_id = $wp_query->get_queried_object_id();

    if (is_home()) {
        $show = isset($instance['page-home']) ? ($instance['page-home']) : false;
    } else if (is_front_page()) {
        $show = isset($instance['page-front']) ? ($instance['page-front']) : false;
    } else if (is_archive()) {
        $show = isset($instance['page-archive']) ? ($instance['page-archive']) : false;
    } else if (is_single()) {
        if (function_exists('get_post_type')) {
            $type = get_post_type();
            if ($type != 'page' and $type != 'post')
                $show = isset($instance['page-' . $type]) ? ($instance['page-' . $type]) : false;
        }

        if (!isset($show))
            $show = isset($instance['page-single']) ? ($instance['page-single']) : false;
    } else if (is_404()) {
        $show = isset($instance['page-404']) ? ($instance['page-404']) : false;
    } else if ($post_id) {
        $show = isset($instance['page-' . $post_id]) ? ($instance['page-' . $post_id]) : false;
    }

    if (!isset($show))
        $show = false;

    if ($show)
        return false;

    return $instance;
}

function templatetoaster_in_widget_form($t, $return, $instance)
{
    $instance = wp_parse_args((array)$instance, array('style' => 'default'));
    $pages = get_posts(array(
        'post_type' => 'page', 'post_status' => 'publish',
        'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC'
    ));
    $wp_page_types = array(
        'front' => __('Front', CURRENT_THEME),
        'home' => __('Blog', CURRENT_THEME),
        'archive' => __('Archives', CURRENT_THEME),
        'single' => __('Single Post', CURRENT_THEME),
        '404' => __('404', CURRENT_THEME)
    );

    ?>
    <label><?php echo esc_attr__('Hide widget on:', CURRENT_THEME); ?></label>
    <div class="menupagecontainer">
        <div class="<?php echo $t->get_field_id(''); ?>">
            <button onclick="select_widget(this);" id="select_button" type="button" class="check-all">Select All
            </button>
            <button onclick="unselect_widget(this);" id="select_button" type="button" class="uncheck-all">UnSelect
                All
            </button>

            <?php foreach ($pages as $page) {
                $instance['page-' . $page->ID] = isset($instance['page-' . $page->ID]) ? $instance['page-' . $page->ID] : false;
                ?>
                <div class="menupageelement">
                    <input class="<?php echo esc_attr(sanitize_html_class($t->get_field_id(''))); ?> widgetcheckbox"
                           type="checkbox" <?php checked($instance['page-' . $page->ID], true) ?>
                           id="<?php echo esc_attr($t->get_field_id('page-' . $page->ID)); ?>"
                           name="<?php echo esc_attr($t->get_field_name('page-' . $page->ID)); ?>"/>
                    <label class="widgetlabel"
                           for="<?php echo esc_attr($t->get_field_id('page-' . $page->ID)); ?>"><?php echo $page->post_title ?></label>
                </div>
            <?php } ?>
            <?php foreach ($wp_page_types as $key => $label) {
                $instance['page-' . $key] = isset($instance['page-' . $key]) ? $instance['page-' . $key] : false;
                ?>
                <div class="menupageelement">
                    <input class="<?php echo esc_attr(sanitize_html_class($t->get_field_id(''))); ?> widgetcheckbox"
                           type="checkbox" <?php checked($instance['page-' . $key], true) ?>
                           id="<?php echo esc_attr($t->get_field_id('page-' . $key)); ?>"
                           name="<?php echo esc_attr($t->get_field_name('page-' . $key)); ?>"/>
                    <label class="widgetlabel"
                           for="<?php echo esc_attr($t->get_field_id('page-' . $key)); ?>"><?php echo $label . ' ' . __('Page', CURRENT_THEME) ?></label>
                </div>
            <?php } ?>

        </div>
    </div>
    <?php if (!isset($instance['style']))
    $instance['style'] = null;
    ?>

    <label
        for="<?php echo esc_attr($t->get_field_id('style')); ?>"><?php echo(__('Block Style:', CURRENT_THEME)); ?></label>
    <select id="<?php echo esc_attr($t->get_field_id('style')); ?>"
            name="<?php echo $t->get_field_name('style'); ?>">
        <option
            <?php selected($instance['style'], 'default'); ?>value="default"><?php echo(__('Default', CURRENT_THEME)); ?></option>
        <option <?php selected($instance['style'], 'none'); ?>
            value="none"><?php echo(__('None', CURRENT_THEME)); ?></option>
        <option
            <?php selected($instance['style'], 'block'); ?>value="block"><?php echo(__('Block', CURRENT_THEME)); ?></option>
    </select>
    <?php
    $retrun = null;
    return array($t, $return, $instance);
}

function templatetoaster_in_widget_form_update($instance, $new_instance, $old_instance)
{
    $pages = get_posts(array(
        'post_type' => 'page', 'post_status' => 'publish',
        'numberposts' => -1, 'orderby' => 'title', 'order' => 'ASC'
    ));
    if ($pages) {

        foreach ($pages as $page) {

            if (isset($new_instance['page-' . $page->ID])) {
                $instance['page-' . $page->ID] = 1;

            } else if (isset($instance['page-' . $page->ID]))
                unset($instance['page-' . $page->ID]);
            unset($page);
        }
    }

    foreach (array('front', 'home', 'archive', 'single', '404') as $page) {
        if (isset($new_instance['page-' . $page])) {
            $instance['page-' . $page] = 1;

        } else if (isset($instance['page-' . $page]))
            unset($instance['page-' . $page]);
    }
    $instance['style'] = $new_instance['style'];
    return $instance;
}

function templatetoaster_add_custom_css()
{
    global $templatetoaster_cssprefix;
    $width = templatetoaster_theme_option('ttr_logo_image_width');
    $height = templatetoaster_theme_option('ttr_logo_image_height');
    $post_title_color = templatetoaster_theme_option("ttr_post_title_color");
    $post_title_hover_color = templatetoaster_theme_option("ttr_post_title_hover_color");
    if (isset($width) && !empty($width)) {
        echo '<style> .navbar-brand, .' . $templatetoaster_cssprefix . 'menu_logo {width:' . $width . 'px !important}</style>';
    }
    if (isset($height) && !empty($height)) {
        echo '<style>  .navbar-brand, .' . $templatetoaster_cssprefix . 'menu_logo {height:' . $height . 'px !important}</style>';
    }

    if (($post_title_color != '#') && !empty($post_title_color)) {
        echo '<style>.' . $templatetoaster_cssprefix . 'post_title, .' . $templatetoaster_cssprefix . 'post_title a,.' . $templatetoaster_cssprefix . 'post_title a:visited{color:' . $post_title_color . ' !important}</style>';
    }

    if (($post_title_hover_color != '#') && !empty($post_title_hover_color)) {
        echo '<style>.' . $templatetoaster_cssprefix . 'post_title a:hover{color:' . $post_title_hover_color . ' !important}</style>';
    }

    $tt_custom_css = templatetoaster_theme_option('ttr_custom_style');
    if (isset($tt_custom_css) && !empty($tt_custom_css))
        echo esc_html('<style type="text/css">' . $tt_custom_css . '</style>');

}

add_action('wp_head', 'templatetoaster_add_custom_css');

function templatetoaster_theme_option($option)
{
    global $templatetoaster_options;
    if (!array_key_exists($option, $templatetoaster_options)) {
        return null;
    }
    return $templatetoaster_options[$option];
}

if (version_compare($GLOBALS['wp_version'], '4.1', '<')) :
    /**
     * Filters wp_title to print a neat <title> tag based on what is being viewed.
     *
     * @param string $title Default title text for current view.
     * @param string $sep Optional separator.
     * @return string The filtered title.
     */
    function templatetoaster_wp_title($title, $sep)
    {
        if (is_feed()) {
            return $title;
        }

        global $page, $paged;

        // Add the blog name
        $title .= get_bloginfo('name', 'display');

        // Add the blog description for the home/front page.
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && (is_home() || is_front_page())) {
            $title .= " $sep $site_description";
        }

        // Add a page number if necessary:
        if (($paged >= 2 || $page >= 2) && !is_404()) {
            $title .= " $sep " . sprintf(__('Page %s', CURRENT_THEME), max($paged, $page));
        }

        return $title;
    }

    add_filter('wp_title', 'templatetoaster_wp_title', 10, 2);

    /**
     * Title shim for sites older than WordPress 4.1.
     *
     * @link https://make.wordpress.org/core/2014/10/29/title-tags-in-4-1/
     * @todo Remove this function when WordPress 4.3 is released.
     */
    function templatetoaster_render_title()
    {
        ?>
        <title><?php wp_title('|', true, 'right'); ?></title>
    <?php
    }

    add_action('wp_head', 'templatetoaster_render_title');
endif;
?>
