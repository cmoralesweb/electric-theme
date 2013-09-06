//Thanks to http://wordpress.stackexchange.com/a/86899/13644

jQuery(document).ready(function($){
    $('.electric-upload-button').click(function(e) {
        //Defaults:
        var multiple = false;
        var previewSize = 'thumbnail';
        var previewType = 'image'; //Set to URL for other files, such as PDFs

        var uploadOptions = $(this).data('upload-options');

        multiple = uploadOptions.multiple
        previewSize = uploadOptions.previewSize
        previewType = uploadOptions.previewType

        upload_image($(this), multiple, previewSize, previewType);
        return false;
    });

    function upload_image(el, multipleAllowed, previewSize, previewType){
        var $ = jQuery;
        var custom_uploader;
        var button = $(el);
        var uploaderTitle;

        //Store the button ID so we can reuse this function
        var id = button.attr('id').replace('_button', '');
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }


        if (multipleAllowed) {
            uploaderTitle = "Choose your images";
        } else {
            uploaderTitle = "Choose your image";
        }

        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: uploaderTitle,
            button: {
                text: "Insert"
            },
            multiple: multipleAllowed
        });

        //When a file is selected, update the preview and store its ID in the hidden field
        custom_uploader.on('select', function() {
            var attachmentsRaw = custom_uploader.state().get('selection');
            var attachmentsIDs = [];
            var $preview = $('#'+id+"_preview");
            var html = "";
            var attachment;
            if ( !multipleAllowed && previewType == "url" ) {
                attachment = attachmentsRaw.models[0].toJSON();
                $('#' + id + "_id").val(attachment.id);
                $('#' + id + "_url").val(attachment.url);
            } else {
                attachmentsRaw.each(function(attachment) {
                    attachment = attachment.toJSON();
                    attachmentsIDs.push(attachment.id);
                    //Check that the requested size exist, return full size otherwise:
                    attachmentURL = attachment.sizes.hasOwnProperty(previewSize) ?
                        attachment.sizes[previewSize].url : attachment.sizes['full'].url;
                    html += '<img src="' + attachmentURL + '" />';
                });
            //Update ID field
            $('#' + id + "_id").val(attachmentsIDs.join());
            if ( $preview.find('img').length > 0 ) {
                //There were images before... delete them and append the new ones.
                $preview.empty();
                $preview.append(html);
            } else {
                $preview.append(html);
            }
        }
    });

        //Open the uploader dialog
        custom_uploader.open();
    }
});


