<?php
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
<?php endif; ?>
<?php query_posts($query_string . '&posts_per_page'); ?>
<?php if (have_posts()) : ?>
    <?php
    the_post();
    ?>
    <h1>
        <?php printf(__('Author Archives:', CURRENT_THEME) . "%s", '<span><a href="' . esc_url(get_author_posts_url(get_the_author_meta("ID"))) . '" title="' . esc_attr(get_the_author()) . '" rel="me">' . get_the_author() . '</a></span>'); ?>
    </h1>
    <?php
    rewind_posts();
    ?>
    <?php templatetoaster_content_nav('nav-above'); ?>
    <?php
    if (get_the_author_meta('description')) : ?>
        <div id="author-info">
            <div id="author-avatar">
                <?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('templatetoaster_author_bio_avatar_size', 60)); ?>
            </div>
            <div id="author-description">
                <h2><?php printf(__('About ', CURRENT_THEME) . "%s", get_the_author()); ?></h2>
                <?php the_author_meta('description'); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php if (isset($_POST[sanitize_key('wp_customize')]) && $_POST[sanitize_key('wp_customize')] == 'on'):
        $layoutoption = 3;
        $featuredpost = 1;
    else:
        $layoutoption = templatetoaster_theme_option('ttr_post_layout');
        $featuredpost = templatetoaster_theme_option('ttr_featured_post');
    endif;?>
    <?php
    if ($layoutoption == 1) {
        while (have_posts()) {
            the_post();
            get_template_part('content', get_post_format());
        }
    } else {
        $featuredcount = 1;
        $columncount = 0;
        $lastpost = true;
        $flag = true;
        while (have_posts()) {
            $lastpost = true;
            if ($featuredcount <= $featuredpost) {
                echo '<div class="row">';
                echo '<div class="col-lg-12">';
                the_post();
                get_template_part('content', get_post_format());
                echo '</div></div>';
                $featuredcount++;
                $lastpost = false;
            } else {
                if ($flag) {
                    echo '<div class=" row">';
                    $flag = false;
                }
                $class_suffix_lg = round((12 / $layoutoption));
                if (empty($class_suffix_lg)) {
                    $class_suffix_lg = 4;
                }
                $md = 4;
                $class_suffix_md = round((12 / $md));
                $xs = 1;
                $class_suffix_xs = round((12 / $xs));
                echo '<div class="col-lg-' . $class_suffix_lg . ' col-md-' . $class_suffix_md . ' col-sm-' . $class_suffix_md . ' col-xs-' . $class_suffix_xs . '">';
                the_post();
                get_template_part('content', get_post_format());
                echo '</div>';
                $columncount++;
                if ($columncount % $xs == 0 && $columncount != 0) {
                    echo '<div class="clearfix visible-xs-block"></div>';
                }
                if ($columncount % $md == 0 && $columncount != 0) {
                    echo '<div class="clearfix visible-sm-block"></div>';
                    echo '<div class="clearfix visible-md-block"></div>';
                }
                if ($columncount % $layoutoption == 0 && $columncount != 0) {
                    echo '<div class="clearfix visible-lg-block"></div>';
                }
                $lastpost = true;
            }
        }
        if (!$flag)){
            echo '</div>';
        }
    }
    ?>
    <div class="clearfix">
        <?php templatetoaster_content_nav('nav-below'); ?>
    </div>
<?php else : ?>
    <h2 class="ttr_post_title">
        <?php _e('Nothing Found', CURRENT_THEME); ?></h2>
    <div class="postcontent">
        <p><?php _e('Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', CURRENT_THEME); ?></p>
        <?php get_search_form(); ?>
        <div class="clearfix"></div>
    </div>
<?php endif; ?>
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
        <div class="clearfix visible-xs-block">
        </div>
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
