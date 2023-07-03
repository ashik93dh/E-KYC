<?php
if (isset($_SESSION['code_time'])){
    if($_SESSION['code_time'] > 3600){
        session_unset();
        session_destroy();
    }
}
function regenerate() {
    $_SESSION['code'] = uniqid();
    $_SESSION['code_time'] = time();
}
function manageSession(){
    session_start();
    if (empty($_SESSION['code']) || time() - $_SESSION['code_time'] > 1500)
    //if there's no code, or the code has expired
    regenerate();
}
function endSession(){
    session_unset();
    session_destroy();
}
function checkSession(){
    if(!isset($_SESSION['code'])){
        header('Location:index.php');
    }
}
?>