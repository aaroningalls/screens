<?php require_once('../require.php');
loggedIn();

$curPassword = filter_input(INPUT_POST, 'curPassword');
$newPassword = filter_input(INPUT_POST, 'newPassword');
$confirm = filter_input(INPUT_POST, 'confirmPassword');

if(!$curPassword || !$newPassword || !$confirm){
    $error = '<p class="error">One of the fields is invalid</p>';
}
$query = 'SELECT password FROM users WHERE userId = :id';
$statement = $db->prepare($query);
$statement->bindValue(':id', $_SESSION['user']);
$statement->execute();
$password = $statement->fetch();
$statement->closeCursor();

if(!password_verify($curPassword, $password['password'])){
    $error = '<p class="error">The current password is invalid</p>';
    $passwordFail = true;
    include('index.php');
    exit;
}

if($newPassword != $confirm){
    $error = '<p class="error">The passwords do not match</p>';
    $passwordFail = true;
    include('index.php');
    exit;
}

$query = 'UPDATE users SET password = :password WHERE userId = :id';
$statement = $db->prepare($query);
$statement->bindValue(':password', password_hash($newPassword, PASSWORD_DEFAULT));
$statement->bindValue(':id', $_SESSION['user']);
$statement->execute();
$statement->closeCursor();

include('index.php');
