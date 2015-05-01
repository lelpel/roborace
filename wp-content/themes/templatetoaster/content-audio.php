<article id="post-<?php the_ID(); ?>" <?php post_class("ttr_post"); ?>>
    <?php if (has_post_thumbnail() && !post_password_required()) : ?>
        <div class="entry-thumbnail">
            <?php the_post_thumbnail(); ?>
        </div>
    <?php endif; ?>
    <div class="ttr_post_content_inner">
        <?php if (isset($_POST[sanitize_key('wp_customize')]) && $_POST[sanitize_key('wp_customize')] == 'on'): ?>
        <div class="ttr_post_inner_box">
            <h1 class="ttr_post_title">
                <?php if (has_post_format(array('link'))): ?>
                <a href="<?php echo esc_url(templatetoaster_get_link_url()); ?>"><?php the_title(); ?></a></h1>
            <?php else: ?>
                <a href="<?php the_permalink(); ?>"
                   title="<?php printf(esc_attr__('Permalink to %s', CURRENT_THEME), the_title_attribute('echo=0')); ?>"
                   rel="bookmark"><?php the_title(); ?></a></h1>
            <?php
            endif;
            ?>
        </div>
        <div class="ttr_article">
            <?php if ('post' == get_post_type()) : ?>
                <?php if (has_post_format(array('chat'))):
                    templatetoaster_entry_meta(); ?>
                <?php else: ?>
                    <?php templatetoaster_posted_on(False, True); ?>
                <?php endif; ?>
            <?php endif; ?>
            <?php else: ?>
            <?php
            $var_all = templatetoaster_theme_option('ttr_all_post_title');
            if ($var_all):?>
                <div class="ttr_post_inner_box">
                    <h1 class="ttr_post_title">
                        <?php if (has_post_format(array('link'))): ?>
                        <a href="<?php echo esc_url(templatetoaster_get_link_url()); ?>"><?php the_title(); ?></a></h1>
                    <?php else: ?>

                        <a href="<?php the_permalink(); ?>"
                           title="<?php printf(esc_attr__('Permalink to %s', CURRENT_THEME), the_title_attribute('echo=0')); ?>"
                           rel="bookmark"><?php the_title(); ?></a></h1>
                    <?php
                    endif;
                    ?>
                </div>
            <?php endif; ?>
            <div class="ttr_article">
                <?php if ('post' == get_post_type()) : ?>
                    <?php if (has_post_format(array('chat'))):
                        templatetoaster_entry_meta(); ?>
                    <?php else: ?>
                        <?php templatetoaster_posted_on(False, True); ?>
                    <?php endif; ?>
                <?php endif; ?>
                <?php endif; ?>
                <?php if (is_search()) : ?>
                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div>
                <?php else : ?>
                    <?php if (isset($_POST[sanitize_key('wp_customize')]) && $_POST[sanitize_key('wp_customize')] == 'on'): ?>
                        <div class="postcontent">
                            <div class="entry-content">
                                <span class="audio-icon"></span>

                                <div class="audio-content">
                                    <?php the_content(__('Continue reading <span>&rarr;</span>', CURRENT_THEME)); ?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="postcontent">
                            <div class="entry-content">
                                <span class="audio-icon"></span>

                                <div class="audio-content">
                                    <?php if (templatetoaster_theme_option('ttr_read_more_button')):
                                        the_content('<span class="button">' . templatetoaster_theme_option('ttr_read_more') . '</span>');
                                    else:
                                        the_content(templatetoaster_theme_option('ttr_read_more'));
                                    endif;?>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php wp_link_pages(array('before' => '<span>' . __('Pages:', CURRENT_THEME) . '</span>', 'after' => '')); ?>
                <?php endif; ?>
                <?php $show_sep = false; ?>
            </div>
        </div>
</article>
