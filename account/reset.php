<?php require_once('../require.php');
if(!isset($error)){
    $error = '<br>';
}
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
    $error = '<p class="error">No valid session was found</p>';
    $session = false;
}
$query = 'SELECT email FROM oneTIme WHERE token = :key';
$statement = $db->prepare($query);
$statement->bindValue(':key', $key);
$statement->execute();
$user = $statement->fetch();
$statement->closeCursor();

if(!$user){
    $error = '<p class="error">No valid session was found</p>';
    $session = false;
} else {
    $_SESSION['resetEmail'] = $user['email'];
}
$headerText = 'Password Reset';
?>
<html>
    <?php include('../view/frontHead.php')?>
    <body>
        <header>
            <title>Password Reset</title>
            <?php include('../view/frontHeader.php')?>
        </header>
        <main>
            <?php echo $error;
            if(!$session){
                exit;
            }?>
            <form action="resetPassword.php"  method="post">
                <div class="grid-container">
                    <label for="password">New Password:</label>
                    <input type="password" name="password" id="password">
                    <label for="confirm">Confirm Password:</label>
                    <input type="password" name="confirm" id="confirm">
                </div>
                <ul class="buttons">
                    <li>
                        <input type="submit" value="Submit">
                    </li>
                </ul>
            </form>
        </main>
    </body>
</html>