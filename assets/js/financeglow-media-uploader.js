jQuery(document).ready(function($) {
    var file_frame;
    
    $('#upload_logo_button').on('click', function(e) {
        e.preventDefault();
        
        // If the media frame already exists, reopen it.
        if (file_frame) {
            file_frame.open();
            return;
        }
        
        // Create a new media frame
        file_frame = wp.media.frames.file_frame = wp.media({
            title: 'Select a Logo',
            button: {
                text: 'Use this logo',
            },
            multiple: false // Set to false to allow only one file to be selected
        });
        
        // When a logo is selected, run a callback.
        file_frame.on('select', function() {
            var attachment = file_frame.state().get('selection').first().toJSON();
            $('#financeglow_logo').val(attachment.url);
        });
        
        // Finally, open the modal
        file_frame.open();
    });
});
