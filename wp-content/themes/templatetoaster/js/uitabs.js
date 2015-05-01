/**
 * uitabs.js 1.0.0
 * @author TemplateToaster
 * GPL Licensed
 */


jQuery(document).ready(function ($) {
    var sections = [];

    sections[pass_data.colorscheme] = "colorscheme";
    sections[pass_data.header] = "header";
    sections[pass_data.menuoptions] = "menuoptions";
    sections[pass_data.postcontent] = "postcontent";
    sections[pass_data.sidebar] = "sidebar";
    sections[pass_data.footer] = "footer";
    sections[pass_data.colors] = "colors";
    sections[pass_data.generaloptions] = "generaloptions";
    sections[pass_data.error] = "error";


    var wrapped = $(".wrap h3").wrap("<div class=\"ui-tabs-panel\">");
    wrapped.each(function () {
        $(this).parent().append($(this).parent().nextUntil("div.ui-tabs-panel"));
    });
    $(".ui-tabs-panel").each(function (index) {
        var abc = sections[$(this).children("h3").text()];
        $(this).attr("id", abc);

    });
    $(".ui-tabs").tabs({
        fx: { opacity: "toggle", duration: "fast" }
    });

    $("input[type=text], textarea").each(function () {
        if ($(this).val() == $(this).attr("placeholder") || $(this).val() == "")
            $(this).css("color", "#999");
    });

    $("input[type=text], textarea").focus(function () {
        if ($(this).val() == $(this).attr("placeholder") || $(this).val() == "") {
            $(this).val("");
            $(this).css("color", "#000");
        }
    }).blur(function () {
        if ($(this).val() == "" || $(this).val() == $(this).attr("placeholder")) {
            $(this).val($(this).attr("placeholder"));
            $(this).css("color", "#999");
        }
    });

    $(".wrap h3, .wrap table").show();


    // Browser compatibility
    if ($.browser.mozilla)
        $("form").attr("autocomplete", "off");


    // ColorPicker jquery
    var s = jQuery('.colorwell');
    $('.colorwell').wpColorPicker();
});
	