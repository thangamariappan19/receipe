"use strict";
jQuery(function($){
	var $uploadCrop; 
    var photo_type;
        // get the size of photo
        var cover_width    = $('#cover_width').val();
        var cover_height   = $('#cover_height').val();
        var profile_width  = $('#profile_width').val();
        var profile_height = $('#profile_height').val();

        // msg show after save the photo

        // open and close model
        $('#wpr-profile-uploader').on('show.bs.modal', function (e) {
            $('.modal .modal-dialog').attr('class', 'modal-dialog   zoomIn   animated');
        })
        $('#wpr-profile-uploader').on('hide.bs.modal', function (e) {
            $('.modal .modal-dialog').attr('class', 'modal-dialog   zoomOut   animated');
        })


        

        $( ".wpr-photo-click" ).click(function( event ) {
            photo_type = $(this).data('photo-type');
            if( $uploadCrop !== undefined ) {
                $('#wpr-upload-img').croppie('destroy');
                $(".crop").hide();
            }
            if( photo_type == 'cover_photo' ) {

                wpr_init_croppie(cover_width, cover_height);
            } else {
                wpr_init_croppie(profile_width, profile_height);
            }
        });

        function readFile(input) { 
             if (input.files && input.files[0]) { 
                var reader = new FileReader(); 
                 
                reader.onload = function (e) { 
                    $uploadCrop.croppie('bind', { 
                        url: e.target.result 
                    }); 
                } 
                 
                reader.readAsDataURL(input.files[0]); 
            } 
            else { 
                alert("Sorry - you're browser doesn't support the FileReader API"); 
            } 
        } 

        
        function wpr_init_croppie( width, height ) {

            width = Number(width);
            height = Number(height);

            var boundary_w = width + 20;
            var boundary_h = height + 20;
            $(".wpr-photo-size-show").html("Photo Width: "+boundary_w + "  Photo Height: "+boundary_h);

            $uploadCrop = $('#wpr-upload-img').croppie({
                viewport: { 
                    width: width, 
                    height: height 
                }, 
                boundary: { 
                    width: boundary_w, 
                    height: boundary_h 
                }
            });
        }
        
        // $('.wpr-pr-hidden').on('click',function(){
        //     $(".modal-content").html("<b>cover_width</b>.<b>cover_width</b>.");
        // });

        $('#wpr-upload-pic').on('change', function () {
            $(".crop").show(); 
            readFile(this);  
        }); 

        $('#wpr-profile-demo').hide();
        $('.wpr-upload-result').on('click', function (ev) {
            $uploadCrop.croppie('result', {
                type: 'canvas',
                circle: false,
                size: 'viewport',
                format: 'png'
            }).then(function (dataURL) {
                
                var image_html = '<img src="' + dataURL + '" />';
                // var photo_type = type;
                if (photo_type == 'user_photo') {
                    $(".wpr-userphoto-render").html(image_html); 
                }else{
                    $(".wpr-cv-uploader").html(image_html);
                }
                

                wpr_save_image(dataURL, photo_type);
                }); 
        });

    // wpr_get_photo_type();
         
    function wpr_save_image(dataURL, type) {

        var data = {'action':'wpr_save_profile_photo', 'photo_type': type, 'data_url': dataURL};
        $.post(wpr_vars.ajax_url, data, function(resp) {
            $('#wpr-profile-demo').show().html('Photo Successfully Upload');
                    // setTimeout(function(){
                    //     $('#wpr-profile-demo').hide();
                    // }, );
        });
    }
});