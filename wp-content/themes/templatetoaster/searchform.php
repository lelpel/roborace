<?php
$options = get_defined_vars();?>
<form method="get" name="searchform" action="<?php echo esc_url(home_url('/')); ?>">
    <input name="s" type="text" value="<?php echo esc_attr(get_search_query()); ?>" class="boxcolor"/>
    <?php if (templatetoaster_theme_option('ttr_search_icon_enable')): ?>
        <input type="submit" name="search" value="" class="searchformimage"
               style="background:url('<?php echo get_template_directory_uri(); ?>/images/search.png');">
    <?php else: ?>
        <div>
            <input type="submit" class="btn btn-default" name="search"
                   value="<?php echo esc_attr__('Search', CURRENT_THEME); ?>"/>

            <div class="clearfix">
            </div>
        </div>
    <?php endif; ?>
</form>
