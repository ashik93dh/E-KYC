// Configure a few settings and attach camera
function configure(){
    Webcam.set({
        width: 400,
        height: 300,
        image_format: "jpg",
        jpeg_quality: 100,
        force_flash: false,
        fps: 45
    });
    Webcam.set("constraints", {
        optional: [{ minWidth: 600 }]
    });
    Webcam.attach( '#my_camera' );
    Webcam.on( 'error', function(err) {
        // an error occurred (see 'err')
    } );
}

function take_snapshot() {
    // play sound effect

    // take snapshot and get image data
    Webcam.snap( function(data_uri) {
        // display results in page
        document.getElementById('cam-title').innerHTML = 
            '<h6>Camera</h6>';
        document.getElementById('results-title').innerHTML = 
            '<h6>Preview</h6>';
        document.getElementById('results').innerHTML = 
            '<img id="imageprev" src="'+data_uri+'"/>';
        var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
        document.getElementById('mydata').value = raw_image_data;
    } );
    Webcam.reset();
    configure();
    document.getElementById('save').style.display='block';
}

function saveSnap(){
    document.getElementById('myform').submit();

}
