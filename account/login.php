<?php 
$login_form = true;
require_once('../require.php');

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password');

if(!$email || !$password){
    $error = '<p class="error">Invalid username or password</p>';
    include('loginForm.php');
    exit;
}

$query = 'SELECT password, userId, privilege FROM users WHERE email = :email';
$statement = $db->prepare($query);
$statement->bindValue(':email', $email);
$statement->execute();
$hash = $statement->fetch();
$statement->closeCursor();

$query = 'SELECT token FROM oneTime WHERE email = :email';
$statement = $db->prepare($query);
$statement->bindValue(':email', $email);
$statement->execute();
$oneTime = $statement->fetch();
if($oneTime != false){
    $query = 'DELETE FROM oneTime WHERE token = :token';
    $statement = $db->prepare($query);
    $statement->bindValue(':token', $oneTime['token']);
    $statement->execute();
    $statement->closeCursor();
}
if(password_verify($password, $hash['password'])){
    $_SESSION['user'] = $hash['userId'];
    $_SESSION['privilege'] = $hash['privilege'];
    header('Location: '.$_SESSION['path']);
} else {
    $failure = true;
    include('loginForm.php');
}