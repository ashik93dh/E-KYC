var loadFile = function(event) {
    var output = document.getElementById('output');
    var input= document.getElementById('image');
    var fname=input.value;
    var re = /(\.jpg|\.jpeg|\.bmp|\.gif|\.png)$/i;
    if (!re.exec(fname)) {
      swal("Only Jpg and Png is supported");
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
  swal("Failed", x, "danger");
}

var loadImage = function(str) {
  var output = document.getElementById('output');
  output.src = str;
  output.onload = function() {
    
  };
  
};

function finalSubmit(){
  document.getElementById("user_data").submit();
  this.disabled=true;
}

function filterData(){
  var input, filter, table, tr, td, i, txtValue,count=0,search_by;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  search_by=document.getElementById("searchby").value;
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[search_by];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
        count++;
      } else {
        tr[i].style.display = "none";
      }
      
    }       
  }
  document.getElementById('tot-row').innerHTML='Total : '+count;
}
function filterDataByName(){
  var input, filter, table, tr, td, i, txtValue,count=0,search_by;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
        count++;
      } else {
        tr[i].style.display = "none";
      }
      
    }       
  }
  document.getElementById('tot-row').innerHTML='Total : '+count;
}