/**
 * CustomScripts.js 1.0.0
 * @author TemplateToaster
 **/
jQuery(document).ready(function () {

    /*
     * Button Style Script
     */
    jQuery("#wp-submit").addClass(" btn btn-default");


    /*
     * Checkbox Script
     */
    var inputs_c = document.getElementsByTagName("input");
    for (a = 0; a < inputs_c.length; a++) {
        if (inputs_c[a].type == "checkbox") {
            var id = inputs_c[a].getAttribute("id");
            if (id == null) {
                id = "checkbox" + a;
            }
            inputs_c[a].setAttribute("id", id);
            var container = document.createElement("div");
            container.setAttribute("class", "ttr_checkbox");
            var label = document.createElement("label");
            label.setAttribute("for", id);
            jQuery(inputs_c[a]).wrap(container).after(label);
        }
    }

    /*
     * RadioButton Script
     */
    var inputs_r = document.getElementsByTagName("input");
    for (a = 0; a < inputs_r.length; a++) {
        if (inputs_r[a].type == "radio") {
            var id = inputs_r[a].getAttribute("id");
            if (id == null) {
                id = "radio" + a;
            }
            inputs_r[a].setAttribute("id", id);
            var container = document.createElement("div");
            container.setAttribute("class", "ttr_radio");
            var label = document.createElement("label");
            label.setAttribute("for", id);
            jQuery(inputs_r[a]).wrap(container).after(label);
        }
    }


    /*
     * Sticky Footer Script
     */
    var window_height = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
    var body_height = jQuery(document.body).height();
    var content = jQuery("#ttr_content_and_sidebar_container");
    if (body_height < window_height) {
        differ = (window_height - body_height);
        content_height = content.height() + differ;
        jQuery("#ttr_content_and_sidebar_container").css("min-height", content_height + "px");
    }

    /*
     * Iframe responsive Script
     */
    var objects = ['iframe', 'video', 'object', 'embed'];
    for (var i = 0; i < objects.length; i++) {
        if (jQuery(objects[i]).length > 0) {
            jQuery(objects[i]).addClass('embed-responsive-item');
            jQuery(objects[i]).parent().addClass('embed-responsive embed-responsive-16by9');

        }
    }

    /*
     * Menu responsive Script
     */
    jQuery('.ttr_menu_items ul.dropdown-menu [data-toggle=dropdown]').on('click', function (event) {
        var window_width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
        event.preventDefault();
        event.stopPropagation();
        jQuery(this).parent().siblings().removeClass('open');
        jQuery(this).parent().toggleClass(function () {
            if (jQuery(this).is(".open")) {
                window.location.href = jQuery(this).children("[data-toggle=dropdown]").attr('href');
                return "";
            } else {
                return "open";
            }
        });
    });

    jQuery('.ttr_vmenu_items ul.collapse [data-toggle=dropdown]').on('click', function () {
        var window_width = Math.max(document.documentElement.clientWidth, window.innerWidth || 0)
        window.location.href = jQuery(this).attr('href');
    });
});