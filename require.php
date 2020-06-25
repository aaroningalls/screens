<?php require_once('database/dbconnect.php');
if(!isset($index)){
    $index = false;
}
if($index){
    set_include_path('vendor/');
} else {
    set_include_path('../vendor');
}
require_once('autoload.php');
use PHPMailer\PHPMailer\PHPMailer; 
function startSession()
{
    if(session_status() == 1){
        session_start();
    }
}

function loggedIn(){
    if(isset($_SESSION['user'])){
        return;
    } else {
        $error = '<p class="error">You must be logged in</p>';
        $_SESSION['path'] = substr(getcwd(), strlen($_SERVER['DOCUMENT_ROOT']));
        include('../account/loginForm.php');
        exit;
    }
}
function sqlError($error, $type){
    $code = $error[1];
    switch($code){
        case 1062:
            if($type == 'email'){
                $error = '<p class="error">A user with this email already exists</p>';
            } else if ($type == 'video'){
                $error = '<p class="error">A video with this ID already exists</p>';
            }
            break;
        default:
            $error = '<p>An error has occurred</p>';
    }
    return $error;
}
function readyMail(){
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPAuth = true;
    $mail->Username = 'dsuscreens@gmail.com';
    $mail->Password = '';
    $mail->setFrom('dsuscreens@gmail.com', 'DSU Screens');
    return $mail;
}
startSession();



