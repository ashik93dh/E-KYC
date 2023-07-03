<?php
if (isset($_SESSION['code_time'])){
    if($_SESSION['code_time'] > 1000){
        session_unset();
        session_destroy();
    }
}

function endSession(){
    session_unset();
    session_destroy();
}
function checkSession(){
    if(!isset($_SESSION['user'])){
        header('Location:index.php');
    }
}
?>