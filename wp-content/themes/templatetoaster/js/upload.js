/**
 * Upload 1.0.0
 * @author TemplateToaster
 * GPL Licensed
 */

jQuery(document).ready(function ($) {

    var uploadID = '';
    /*setup the var*/

    jQuery('.ttrbutton').click(function () {
        uploadID = $(this).parent().find("input[type='text']");
        formfield = $('.upload').attr('name');
        tb_show('Upload', 'media-upload.php?referer=functions.php&amp;type=image&amp;TB_iframe=true', false);
        return false;
    });

    window.send_to_editor = function (html) {
        imgurl = $('img', html).attr('src');
        uploadID.val(imgurl);
        /*assign the value to the input*/

        tb_remove();
        $('#button').trigger('click');

        var horizontal = uploadID.parent().parent().next('tr');
        var vertical = uploadID.parent().parent().next('tr').next('tr');
        var stretch = uploadID.parent().parent().next('tr').next('tr').next('tr');

        if (uploadID.val() != "") {
            horizontal.css("display", "");
            vertical.css("display", "");
            stretch.css("display", "");
        }

    };


});