<?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package templatetoaster
 */
?>
<div id="comments">
    <?php if (post_password_required()) : ?>
    <p class="nopassword"><?php _e('This post is password protected. Enter the password to view any comments.', CURRENT_THEME); ?></p>
</div>
<?php
return;
endif;
?>
<?php
$comment_form_show_on = templatetoaster_theme_option('ttr_comment_list_form');
if (templatetoaster_theme_option('ttr_comment_list_form') == "choice2") {
    templatetoaster_theme_comment_form($templatetoaster_cssprefix = 'ttr_');
} ?>
<?php if (templatetoaster_theme_option('ttr_comments_list')): ?>
    <?php if (have_comments()) : ?>
        <h2 id="comments-title">
            <?php
            printf(_n('One thought on &ldquo;%2$s&rdquo;', '%s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), CURRENT_THEME),
                number_format_i18n(get_comments_number()), '<span>' . get_the_title() . '</span>');
            ?>
        </h2>
    <?php endif; ?>
    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
        <nav id="comment-nav-above">
            <h1 class="assistive-text"><?php _e('Comment navigation', CURRENT_THEME); ?></h1>

            <div
                class="nav-previous"><?php previous_comments_link('&larr; ' . __('Older Comments', CURRENT_THEME)); ?></div>
            <div
                class="nav-next"><?php next_comments_link(__('Newer Comments', CURRENT_THEME) . ' &rarr;'); ?></div>
        </nav>
    <?php endif; ?>
    <ol class="commentlist">
        <?php
        wp_list_comments(array(
            'style' => 'ol',
            'short_ping' => true,
            'avatar_size' => templatetoaster_theme_option('ttr_avatar_size'),
            'callback' => 'templatetoaster_comment_call',
        ));
        ?>
    </ol>
    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) :
        ?>
        <nav id="comment-nav-below">
            <h1 class="assistive-text"><?php _e('Comment navigation', CURRENT_THEME); ?></h1>

            <div
                class="nav-previous"><?php previous_comments_link(__('&larr; Older Comments', CURRENT_THEME)); ?></div>
            <div
                class="nav-next"><?php next_comments_link(__('Newer Comments', CURRENT_THEME) . ' &rarr;'); ?></div>
        </nav>
    <?php endif; ?>
<?php
elseif (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) :
    ?>
    <?php if (templatetoaster_theme_option('ttr_comments_closed_text')) { ?>
    <p class="nocomments"><?php _e('Comments are closed.', CURRENT_THEME); ?></p>
<?php } ?>
<?php endif; ?>
<?php if (templatetoaster_theme_option('ttr_comment_list_form') == "choice1") {
    templatetoaster_theme_comment_form($templatetoaster_cssprefix = 'ttr_');
} ?>
</div>
<?php
function templatetoaster_comment_call($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
    <div id="comment-<?php comment_ID(); ?>" class="ttr_comments">
        <div class="ttr_comments">
            <div class="ttr_comment_author"
                 style="width:<?php echo esc_attr(templatetoaster_theme_option('ttr_avatar_size')); ?>px;">
                <?php echo get_avatar($comment, templatetoaster_theme_option('ttr_avatar_size')); ?>
            </div>
            <?php $margin_left = templatetoaster_theme_option('ttr_avatar_size') + 10; ?>
            <div class="ttr_comment_text" style="margin-left:<?php echo $margin_left ?>px;">
<span><a class="ttr_author_name" href="<?php echo esc_url(get_comment_link($comment->comment_ID)) ?>"><?php
        echo get_comment_author_link($comment->comment_ID); ?></a>
</span>
                <time datetime="<?php echo esc_attr(get_comment_date("c")); ?>" class="comment-date">
                    <a class="ttr_comment_date"
                       href="<?php echo esc_url(get_comment_link($comment->comment_ID)) ?>"><?php printf('%s ' . __('at', CURRENT_THEME) . ' %2$s', get_comment_date(), get_comment_time()) ?></a>
                </time>
                <hr class="comment_hr"/>
                <?php comment_text() ?>
                <div class="clearfix"></div>
                <hr class="comment_hr"/>
                <div class="clearfix"></div>
                <div class="ttr_comment_reply_edit">
                    <span
                        class="ttr_reply_edit"><?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></span>
                    <span
                        class="ttr_reply_edit"><?php edit_comment_link('(' . __('Edit', CURRENT_THEME) . ')') ?></span>
                </div>
                <?php if ($comment->comment_approved == '0') : ?>
                    <br/><em><?php _e('Your comment is awaiting approval.', CURRENT_THEME) ?></em>
                <?php endif; ?>
            </div>
            <div class="ttr_comment_author_right">
                <?php echo get_avatar($comment->comment_author_email); ?>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php } ?>
