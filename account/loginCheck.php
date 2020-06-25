<?php

function isLoggedIn(){
    if(isset($_SESSION['user'])){
        return true;
    } else {
        return false;
    }
}

function loggedIn(){
    if(isset($_SESSION['user'])){
        return;;
    } else {
        $error = '<p class="error">You must be logged in</p>';
        $_SESSION['path'] = substr(getcwd(), 37);
        include('../account/loginForm.php');
        exit;
    }
}