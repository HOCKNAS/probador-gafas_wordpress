function sck_remove_image() {
    jQuery('#tryon-glasses').val('');
    jQuery('#picsrc').hide();
}

function sck_upload_image() {
    var send_attachment_bkp = wp.media.editor.send.attachment;
    wp.media.editor.send.attachment = function(props, attachment) {
        jQuery('#tryon-glasses').val(attachment.url);
        jQuery('#picsrc').css("display", "block");
        jQuery('#picsrc').attr('src', attachment.url);
        wp.media.editor.send.attachment = send_attachment_bkp;
    }
    wp.media.editor.open();
}