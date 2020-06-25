<?php require_once('../require.php');
loggedIn();

$user = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);
if(!$user){
    $error = '<p class="error">The input was not as expected. Please try again</p>';
}
if($_SESSION['privilege'] == 0){
    $error = '<p class="error">You do not have the privilege for this operation</p>';
    include('editUser.php');
    exit;
}

$query = 'SELECT privilege FROM users WHERE userId = :id';
$statement = $db->prepare($query);
$statement->bindValue(':id', $_SESSION['user']);
$statement->execute();
$privilege = $statement->fetch();
$statement->closeCursor();

if($privilege >= $_SESSION['privilege']){
    $error = '<p class="error">You do not have the privilege for this operation</p>';
    include('editUser.php');
    exit;
}
$query = 'DELETE FROM users WHERE userId = :id';
$statement = $db->prepare($query);
$statement->bindValue(':id', $user);
$statement->execute();
$statement->closeCursor();
include('users.php');