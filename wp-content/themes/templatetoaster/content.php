<?php
/**
 * @package templatetoaster
 */
?>
<article <?php post_class("ttr_post"); ?>>
    <?php if (has_post_thumbnail() && !post_password_required()) : ?>
        <div class="entry-thumbnail">
            <?php the_post_thumbnail(); ?>
        </div>
    <?php endif; ?>
    <div class="ttr_post_content_inner">
        <?php
        if (isset($_POST[sanitize_key('wp_customize')]) && $_POST[sanitize_key('wp_customize')] == 'on'): ?>
        <div class="ttr_post_inner_box">
            <h2 class="ttr_post_title">
                <a href="<?php the_permalink(); ?>"
                   title="<?php printf(esc_attr__('Permalink to %s', CURRENT_THEME), the_title_attribute('echo=0')); ?>"
                   rel="bookmark"><?php the_title(); ?></a></h2>
        </div>
        <div class="ttr_article">
            <?php if ('post' == get_post_type()) : ?>
                <?php templatetoaster_posted_on(False, True); ?>
            <?php endif; ?>
            <?php else: ?>
            <?php $var_all = templatetoaster_theme_option('ttr_all_post_title');
            if ($var_all):?>
                <div class="ttr_post_inner_box">
                    <h2 class="ttr_post_title">
                        <a href="<?php the_permalink(); ?>"
                           title="<?php printf(esc_attr__('Permalink to %s', CURRENT_THEME), the_title_attribute('echo=0')); ?>"
                           rel="bookmark">
                            <?php the_title(); ?></a></h2>
                </div>
            <?php endif; ?>
            <div class="ttr_article">
                <?php if ('post' == get_post_type()) : ?>
                    <?php templatetoaster_posted_on(False, True); ?>
                <?php endif; ?>
                <?php endif; ?>
                <?php if (is_search()) : ?>
                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div>
                <?php else : ?>
                    <?php
                    if (isset($_POST[sanitize_key('wp_customize')]) && $_POST[sanitize_key('wp_customize')] == 'on'):?>
                        <div class="postcontent">
                            <?php the_content(__('Continue reading', CURRENT_THEME) . ' <span>&rarr;</span>'); ?>
                            <div class="clearfix"></div>
                        </div>
                    <?php else: ?>
                        <div class="postcontent">
                            <?php if (templatetoaster_theme_option('ttr_post_breadcrumb')): ?>
                                <?php templatetoaster_wordpress_breadcrumbs(); ?>
                            <?php endif; ?>
                            <?php if (templatetoaster_theme_option('ttr_read_more_button')):
                                the_content('<span class="button">' . templatetoaster_theme_option('ttr_read_more') . '</span>');
                            else:
                                the_content(templatetoaster_theme_option('ttr_read_more'));
                            endif;?>
                            <div class="clearfix"></div>
                        </div>
                    <?php endif; ?>
                    <?php wp_link_pages(array('before' => '<span>' . __('Pages:', CURRENT_THEME) . '</span>', 'after' => '')); ?>
                <?php endif; ?>
                <?php $show_sep = false; ?>
                <div>
                    <?php
                    if (isset($_POST[sanitize_key('wp_customize')]) && $_POST[sanitize_key('wp_customize')] == 'on'):?>
                        <?php if ('post' == get_post_type()) : ?>
                            <?php
                            $categories_list = get_the_category_list(__(', ', CURRENT_THEME));
                            if ($categories_list):
                                ?>
                                <?php printf('<span class="meta">' . __('Posted in', CURRENT_THEME) . ' </span> %2$s', '', $categories_list);
                                $show_sep = true; ?>
                            <?php endif; ?>
                            <?php
                            $tags_list = get_the_tag_list('', __(', ', CURRENT_THEME));
                            if ($tags_list):
                                if ($show_sep) : ?>
                                    <span class="meta-sep">|</span>
                                <?php endif; ?>
                                <?php printf(__('Tagged', CURRENT_THEME), ' %2$s entry-utility-prep entry-utility-prep-tag-links', $tags_list);
                                $show_sep = true; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php if (templatetoaster_theme_option('ttr_remove_post_category')): ?>
                            <?php if ('post' == get_post_type()) : ?>
                                <?php
                                $categories_list = get_the_category_list(__(', ', CURRENT_THEME));
                                if ($categories_list):
                                    ?>
                                    <?php printf('<span class="meta">' . __('Posted in', CURRENT_THEME) . ' </span> %2$s', '', $categories_list);
                                    $show_sep = true; ?>
                                <?php endif; ?>
                                <?php
                                $tags_list = get_the_tag_list('', __(', ', CURRENT_THEME));
                                if ($tags_list):
                                    if ($show_sep) : ?>
                                        <span class="meta-sep">|</span>
                                    <?php endif; ?>
                                    <?php printf(__('Tagged', CURRENT_THEME), ' %2$s entry-utility-prep entry-utility-prep-tag-links', $tags_list);
                                    $show_sep = true; ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($show_sep) : ?>
                        <span class="meta-sep">|</span>
                    <?php endif; ?>
                    <?php if (comments_open()) : ?>
                        <?php comments_popup_link('<span class="leave-reply">' . __('Leave a reply', CURRENT_THEME) . '</span>', __('<b>1</b> Reply', CURRENT_THEME), '<b>%</b> ' . __('Replies', CURRENT_THEME)); ?>
                        <span class="meta-sep">|</span>
                    <?php endif; ?>
                    <?php if ($post = get_post($id) and $url = get_edit_post_link($post->ID)) {
                        $link = __('Edit This', CURRENT_THEME);
                        $post_type_obj = get_post_type_object($post->post_type);
                        $link = '<a href="' . $url . '" title="' . esc_attr($post_type_obj->labels->edit_item) . '">' . $link . '</a>';
                        echo '<span class="edit-link">' . apply_filters('edit_post_link', $link, $post->ID) . '</span>';
                    }
                    ?>
                </div>
            </div>
        </div>
</article>
