<?php require_once('../require.php');

$first = filter_input(INPUT_POST, 'first');
$last = filter_input(INPUT_POST, 'last');
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$password = filter_input(INPUT_POST, 'password');
$confirm = filter_input(INPUT_POST, 'confirm');

if(!$first || !$last || !$email || !$password || !$confirm){
    $error = '<p class="error">One or more of the fields are invalid</p>';
    include('create.php');
    exit;
}
if($password != $confirm){
    $error = '<p class="error">The passwords do not match</p>';
    include('create.php');
    exit;
}
$query = 'INSERT INTO users (firstName, lastName, email, password, privilege) VALUES (:first, :last, :email, :password, :privilege)';
$statement = $db->prepare($query);
$statement->bindValue(':first', $first);
$statement->bindValue(':last', $last);
$statement->bindValue(':email', $email);
$statement->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
$statement->bindValue(':privilege', $_SESSION['newPrivilege'] / 10);
$statement->execute();
$statement->closeCursor();

$query = 'DELETE FROM oneTime WHERE email = :email';
$statement = $db->prepare($query);
$statement->bindValue(':email', $email);
$statement->execute();
$statement->closeCursor();

unset($_SESSION['key']);
?>
