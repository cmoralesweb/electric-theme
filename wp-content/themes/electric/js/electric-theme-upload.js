//Thanks to http://wordpress.stackexchange.com/a/86899/13644

jQuery(document).ready(function($){
    $('#upload-logo-button').click(function(e) {
        e.preventDefault();
        upload_image($(this));
        return false;
    });
});
function upload_image(el){
    var $ = jQuery;
    var custom_uploader;
    var button = $(el);
    var id = button.attr('id').replace('_button', '');
    if (custom_uploader) {
        custom_uploader.open();
        return;
    }

    //Extend the wp.media object
    custom_uploader = wp.media.frames.file_frame = wp.media({
        title: electricThOp.choose_logo,
        button: {
            text: electricThOp.insert
        },
        multiple: false
    });

    //When a file is selected, grab the URL and set it as the text field's value
    custom_uploader.on('select', function() {
        attachment = custom_uploader.state().get('selection').first().toJSON();

        $('#upload-logo-preview img').attr('src', attachment.url);
        $('#logo-image').val(attachment.url);
        $('#logo-image-id').val(attachment.id);

    });

    //Open the uploader dialog
    custom_uploader.open();
}

