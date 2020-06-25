<?php require_once('../require.php');

if(!isset($session)){
    $session = true;
}
if(!isset($_SESSION['key'])){
    $key = filter_input(INPUT_GET, 'key');
    $_SESSION['key'] = $key;
} else {
    $key = $_SESSION['key'];
}
if(!$key){
    $error = '<p class="error">No session key has been provided</p>';
    $session = false;
} else {
    $query = 'SELECT email, useCase FROM oneTime WHERE token = :key';
    $statement = $db->prepare($query);
    $statement->bindValue(':key', $key);
    $statement->execute();
    $email = $statement->fetch();
    $statement->closeCursor();
    if (!$email) {
        $error = '<p class="error">No matching session was found</p>';
        $session = false;
    } else {
        $query = 'UPDATE users email = :email WHERE email = :oldEmail';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email['useCase']);
        $statement->bindValue(':oldEmail', $email['email']);
        $statement->execute();
        $statement->closeCursor();

        $query = 'DELETE FROM oneTime WHERE token = :key';
        $statement = $db->prepare($query);
        $statement->bindValue(':key', $key);
        $statement->execute();
        $statement->closeCursor();
        $error = '<p>Your email has been successfully updated</p>';

    }
}
?>
<html>
    <head>
        <?php include('../view/frontHead.php'); ?>
        </style>
    </head>
    <body>
        <?php include('../view/frontHeader.php')?>
        <main>
            <?php echo $error?>
        </main>
    </body>
</html>



