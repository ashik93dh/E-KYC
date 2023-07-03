<?php
if (isset($_SESSION['code_time'])){
    if($_SESSION['code_time'] > 3600){
        session_unset();
        session_destroy();
    }
}
function manageSession(){
    session_start();
}
function endSession(){
    session_unset();
    session_destroy();
}
function checkSession(){
    if(!isset($_SESSION['user'])){
        header('Location:login.php');
    }
}
?>