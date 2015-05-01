<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="ttr_post">
        <div class="postcontent">
            <div class="entry-content">
                <?php if (isset($_POST[sanitize_key('wp_customize')]) && $_POST[sanitize_key('wp_customize')] == 'on'): ?>
                    <?php the_content(__('Continue reading', CURRENT_THEME) . ' <span class="meta-nav">&rarr;</span>'); ?>
                    <?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', CURRENT_THEME) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
                <?php else: ?>
                    <?php if (templatetoaster_theme_option('ttr_read_more_button')):
                        the_content('<span class="button">' . templatetoaster_theme_option('ttr_read_more') . '</span>');
                    else:
                        the_content(templatetoaster_theme_option('ttr_read_more'));
                    endif;?>
                    <?php wp_link_pages(array('before' => '<div class="page-links"><span class="page-links-title">' . __('Pages:', CURRENT_THEME) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>')); ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="entry-meta">
            <?php templatetoaster_entry_meta(); ?>
            <?php if (comments_open() && !is_single()) : ?>
                <span class="comments-link">
<?php comments_popup_link('<span class="leave-reply">' . __('Leave a comment', CURRENT_THEME) . '</span>', __('One comment so far', CURRENT_THEME), __('View all % comments', CURRENT_THEME)); ?>
</span><!-- .comments-link -->
            <?php endif; // comments_open() ?>
            <?php edit_post_link(__('Edit This', CURRENT_THEME), '<span class="edit-link">', '</span>'); ?>
        </div>
        <!-- .entry-meta -->
    </div>
</article><!-- #post -->
