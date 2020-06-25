<?php require_once('../require.php');
loggedIn();

$id = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);
if(!$id){
    $error = '<p class="error">The input was not as expected. Please try again</p>';
}
if($_SESSION['privilege'] == 0){
    $error = '<p class="error">You do not have the privilege to perform this action</p>';
    $user = $id;
    include('editUser.php');
    exit;
}

$query = 'SELECT privilege FROM users WHERE userId = :id';
$statement = $db->prepare($query);
$statement->bindValue(':id', $id);
$statement->execute();
$privilege = $statement->fetch();
$statement->closeCursor();

if($privilege['privilege'] >= $_SESSION['privilege']){
    $error = '<p class="error">You do not have the privilege to perform this action</p>';
    $user = $id;
    include('editUser.php');
    exit;
}

$first = filter_input(INPUT_POST, 'firstName');
$last = filter_input(INPUT_POST, 'lastName');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$privilege = filter_input(INPUT_POST, 'privilege', FILTER_VALIDATE_INT);


if(!$first || !$last || !$email || !$privilege){
    $error = '<p class="error">One or more fields are invalid. Please try again</p>';
    $user = $id;
    include('editUser.php');
    exit;
}

$query = 'UPDATE users SET firstName = :first, lastName = :last, email = :email, privilege = :privilege WHERE userId = :id';
$statement = $db->prepare($query);
$statement->bindValue(':first', $first);
$statement->bindValue(':last', $last);
$statement->bindValue(':email', $email);
$statement->bindValue(':privilege', $privilege);
$statement->bindValue(':id', $id);
$statement->execute();
$statement->closeCursor();

include('users.php');