
     
     // convert bytes into friendly format
    function bytesToSize(bytes) {

        var sizes = ['Bytes', 'KB', 'MB'];
        if (bytes == 0) return 'n/a';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return (bytes / Math.pow(1024, i)).toFixed(1) + ' ' + sizes[i];

    };

    // update info by cropping (onChange and onSelect events handler)
    function updateInfo(e) {

        $('#x1').val(e.x);
        $('#y1').val(e.y);
        $('#x2').val(e.x2);
        $('#y2').val(e.y2);
        $('#w').val(e.w);
        $('#h').val(e.h);
        
    };

    // clear info by cropping (onRelease event handler)
    function clearInfo() {

        $('.info #w').val('');
        $('.info #h').val('');
    };

    // Create variables (in this scope) to hold the Jcrop API and image size
    var jcrop_api, boundx, boundy;

    function fileSelectHandler(){
        
        // get selected file
        var oFile = $('#image_file')[0].files[0];

        
        // hide all errors
        $('.error').hide();

        
        // check for image type (jpg and png are allowed)
        var rFilter = /^(image\/jpeg|image\/png)$/i;
        if (! rFilter.test(oFile.type)) {
            $('.error').html('Please select a valid image file (jpg and png are allowed)').show();
            return;
        }
        
        // preview element
        var oImage = document.getElementById('preview');

        // prepare HTML5 FileReader
        var oReader = new FileReader();
            oReader.onload = function(e) {

            // e.target.result contains the DataURL which we can use as a source of the image
            oImage.src = e.target.result;
            oImage.onload = function () { // onload event handler

                // display step 2
                $('.step2').slideDown(500);
                
                // display some basic image info
                var sResultFileSize = bytesToSize(oFile.size);
                $('#filesize').val(sResultFileSize);
                $('#filetype').val(oFile.type);
                $('#filedim').val(oImage.naturalWidth + ' x ' + oImage.naturalHeight);

                
                // destroy Jcrop if it is existed
                if (typeof jcrop_api != 'undefined') {
                    jcrop_api.destroy();
                    jcrop_api = null;
                    $('#preview').width(oImage.naturalWidth);
                    $('#preview').height(oImage.naturalHeight);
                }

                function createJcropArea() {
                    
                    //These are the coördinates for the default crop
                    var W = 200;
                    var H = W/4*3;
                    
                    var x1 = $("#preview").width()/2 - W/2;
                    var y1 = $("#preview").height()/2 - H/2;
                    var x2 = x1 + W;
                    var y2 = y1 + H;
                    
                    
                    $('#RealWidth').val(oImage.naturalWidth);
                    $('#RealHeight').val(oImage.naturalHeight);

                    // initialize Jcrop
                    $('#preview').Jcrop({
                        minSize: [32, 32], // min crop size
                        aspectRatio : 4/3, // keep aspect ratio 4:3
                        bgFade: true, // use fade effect
                        bgOpacity: .3, // fade opacity
                        setSelect: [x1, y1, x2, y2],
                        onChange: updateInfo,
                        onSelect: updateInfo,
                        onRelease: clearInfo
                    }, function(){

                        // use the Jcrop API to get the real image size
                        var bounds = this.getBounds();
                        boundx = bounds[0];
                        boundy = bounds[1];

                        // Store the Jcrop API in the jcrop_api variable
                        jcrop_api = this;
                    });

                    clearInterval(interval);
                }
                
                var interval = setInterval(createJcropArea, 1000);
                
            };
        };

        // read selected file as DataURL
        oReader.readAsDataURL(oFile);
    }