<?php require_once('../require.php');

$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
if(!$email){
    $error = '<p class="error">The email is invalid</p>';
    include('forgot.php');
    exit;
}
$query = 'SELECT userId FROM users WHERE email = :email';
$statement = $db->prepare($query);
$statement->bindValue(':email', $email);
$statement->execute();
$valid = $statement->fetch();
$statement->closeCursor();
$mail = readyMail();
if($valid != false){
    $key = password_hash(date('Y-m-d H:i:s'), PASSWORD_DEFAULT);
    $query = 'INSERT INTO oneTime (email, token, useCase) VALUES (:email, :key, -5)';
    $statement = $db->prepare($query);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':key', $key);
    $statement->execute();
    $statement->closeCursor();
    
    $mail->addAddress($email);
    $mail->Subject = 'Password Reset';
    $mail->Body = '<p>You have requested a password reset for the DSU Screen manager
                    Click the link below to reset your password: <br>
                    <a href="http://localhost/account/reset.php?key='.$key.'">http://localhost/account/reset.php?key='.$key.'</a></p>';
    $mail->isHTML(true);
}
?>
<html>
    <head>
        <?php include('../view/frontHead.php')?>
    </head>
    <body>
        <header>
            <?php include('../view/frontHeader.php')?>
        </header>
        <main>
            <?php if($mail->send()):?>
                <h1>Email sent</h1>
                <p>Please check your inbox. Make sure to check your spam folder if you can't find it</p>
            <?php else:
                $error = '<p class="error">There was an error. Please try again later</p>';
                include('reset.php');
            endif;?>
        </main>
    </body>
</html>