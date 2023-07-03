var loadFile = function(event) {
    var output = document.getElementById('output');
    var input= document.getElementById('image');
    var fname=input.value;
    var re = /(\.jpg|\.jpeg|\.bmp|\.gif|\.png)$/i;
    if (!re.exec(fname)) {
      swal("Only Jpg,Bmp,Gif and Png is supported");
      input.value="";
    }
    else{
      output.src = URL.createObjectURL(event.target.files[0]);
      document.getElementById("submit").style.display = "block";
      output.onload = function() {
        URL.revokeObjectURL(output.src) // free memory
      }
    }
  };
function loadEvent(event) {
  document.getElementById("loader").style.display = "block";
}
function submitSuccess(event) {
  swal("Success", "Image Uploaded Successfully", "success");
}
function customAlertSuccess(x) {
  swal("Success", x, "success");
}
function customAlertFail(x) {
  Swal.fire({
    icon: 'error',
    title: 'Error',
    text: x,
    
  })
}

function finalSubmit(event){
  document.getElementById("logout").style.display='block';
}


