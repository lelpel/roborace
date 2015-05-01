<?php
if (!is_active_sidebar('first-footer-widget-area') && !is_active_sidebar('second-footer-widget-area') && !is_active_sidebar('third-footer-widget-area'))
    return;
?>
<div class="footer-widget-area_fixed" role="complementary">
    <div class="footerwidget" role="complementary">
        <?php if (is_active_sidebar('first-footer-widget-area')) : ?>
            <div id="first" class="widget-area">
                <?php templatetoaster_theme_dynamic_sidebar('first-footer-widget-area'); ?>
            </div>
        <?php else: ?>
            <div id="first" class="widget-area">
                &nbsp;
            </div>
        <?php endif; ?>
        <?php if (is_active_sidebar('second-footer-widget-area')) : ?>
            <div id="second" class="widget-area">
                <?php templatetoaster_theme_dynamic_sidebar('second-footer-widget-area'); ?>
            </div>
        <?php else: ?>
            <div id="second" class="widget-area">
                &nbsp;
            </div>
        <?php endif; ?>
        <?php if (is_active_sidebar('third-footer-widget-area')) : ?>
            <div id="third" class="widget-area">
                <?php templatetoaster_theme_dynamic_sidebar('third-footer-widget-area'); ?>
            </div>
        <?php else: ?>
            <div id="third" class="widget-area">
                &nbsp;
            </div>
        <?php endif; ?>
        <div class="clearfix"></div>
    </div>
</div>
