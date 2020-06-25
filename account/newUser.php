<?php require_once('../require.php');
loggedIn();

if($_SESSION['privilege'] == 0){
    $error = '<p class="error">You do not have the privilege to perform this action</p>';
    include('users.php');
    exit;
}

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$privilege = filter_input(INPUT_POST, 'privilege');

if(!$email || !$privilege){
    $error = 'One or more fields are invalid. Please try again';
    include('users.php');
    exit;
} else {
    $privilege--;
}
$query = 'SELECT userId FROM users WHERE email = :email ';
$statement = $db->prepare($query);
$statement->bindValue(':email', $email);
$statement->execute();
$userExist = $statement->fetch();
$statement->closeCursor();

if($userExist != false){
    echo 'bad';
    exit;
}

$key = password_hash(date('Y-m-d H:i:s'), PASSWORD_DEFAULT);
$privilege *= 10;

$query = "INSERT INTO oneTime (email, token, useCase) VALUES (:email, :key, :privilege)";
$statement = $db->prepare($query);
$statement->bindValue(':email', $email);
$statement->bindValue(':key', $key);
$statement->bindValue(':privilege', $privilege);
$success = $statement->execute();
$statement->closeCursor();

if(!$success){
    $error = sqlError($statement->errorInfo(), 'email');
    include('users.php');
    exit;
} 
$mail = readyMail();
$mail->addAddress($email);
$mail->Subject = 'Create Account';
$mail->Body = '<p>You have been invited to help manage the videos for the DSU screen manager.
                Click the link below to create your account: <br>
                <a href="http://localhost/account/create.php?key='.$key.'">localhost/account/create.php?key='.$key.'</a><p>';
$mail->isHTML(true);
if($mail->send()){
    echo 'cool';
} else{
    echo $mail->ErrorInfo;
}
