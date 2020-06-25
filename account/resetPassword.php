<?php require_once('../require.php');

$password = filter_input(INPUT_POST, 'password');
$confirm = filter_input(INPUT_POST, 'confirm');
if(!$password || !$confirm){
    $error = '<p class="error">One or more fields are invalid</p>';
    include('reset.php');
    exit;
}
if($password != $confirm){
    $error = '<p class="error">The passwords do not match</p>';
    include('reset.php');
    exit;
}
$query = 'UPDATE users SET password = :password WHERE email = :email';
$statement = $db->prepare($query);
$statement->bindValue(':email', $_SESSION['resetEmail']);
$statement->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
$statement->execute();
$statement->closeCursor();

$query = 'DELETE FROM oneTime WHERE token = :key';
$statement = $db->prepare($query);
$statement->bindValue(':key', $_SESSION['key']);
$statement->execute();
$statement->closeCursor();

$mail = readyMail();
$mail->addAddress($_SESSION['resetEmail']);
$mail->Subject = 'Password Reset Complete';
$mail->Body = '<p>Your password has been successfully reset for the DSU Screen Manager. If this wasn\'t you please contact
                us at <a href="mailto:dsuscreens@gmail.com?subject=Unapproved%20Password%20Reset">dsuscreens@gmail.com</a>
                with the email associated with your account.</p>';
$mail->isHTML(true);
if($mail->send()){
    echo 'cool';
} else {
    echo $mail->ErrorInfo;
}
unset($_SESSION['key']);
unset($_SESSION['resetEmail']);