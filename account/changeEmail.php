<?php require_once('../require.php');
loggedIn();

$email = filter_input(INPUT_POST, 'newEmail', FILTER_VALIDATE_EMAIL);
$confirm = filter_input(INPUT_POST, 'confirmEmail', FILTER_VALIDATE_EMAIL);

if(!$email || !$confirm){
    $error = '<p class="error">One of the email fields is invalid</p>';
    $emailFail = true;
    include('index.php');
    exit;
}
if(!$email != !$confirm){
    $error = '<p class="error">The emails do not match</p>';
    $emailFail = true;
    include('index.php');
    exit;
}

$query = 'SELECT email FROM users WHERE userId = :id';
$statement = $db->prepare($query);
$statement->bindValue(':id', $_SESSION['user']);
$statement->execute();
$curEmail = $statement->fetch();
$statement->closeCursor();

$key = password_hash(date('Y-m-d H:i:s'), PASSWORD_DEFAULT);


$mail = readyMail();
$mail->addAddress($curEmail['email']);
$mail->Subject = 'Email Change';
$mail->Body = '<h1>Email Change Request</h1>
                <p>You have requested to change the email for your DSU Screen Manager account to '.$email.'. Please
                visit the link to confirm your change:<br>
                <a href="http://localhost/account/updateEmail.php?key='.$key.'">http://localhost/account/updateEmail.php?key='.$key.'</a><br>
                Not you? Reset your password <a href="http://localhost/account.php">here</a></p>';
$mail->isHTML(true);
if($mail->send()){
    $query = 'INSERT INTO oneTime (email, token, useCase) VALUES (:curEmail, :key, :email)';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $curEmail['email']);
    $statement->bindValue(':key', $key);
    $statement->bindValue(':curEmail', $email);
    $statement->execute();
    $statement->closeCursor();
    $error = '<p>A confirmation email has been sent to '.$curEmail['email'].'</p>';
    include('index.php');
} else {
    $error = $mail->ErrorInfo;
    include('index.php');
}


