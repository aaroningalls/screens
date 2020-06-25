<?php require_once('../require.php');
if(!isset($error)){
    $error = '';
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
    $error = '<p>No session has been provided</p>';
    $session = false;
} else {
    $query = 'SELECT email, useCase FROM oneTime WHERE token = :key';
    $statement = $db->prepare($query);
    $statement->bindValue(':key', $key);
    $statement->execute();
    $user = $statement->fetch();
    $statement->closeCursor();

    if(!$user){
        $error = '<p>No matching session has been found</p>';
        $session = false;
    } 
}
$_SESSION['newPrivilege'] = $user['useCase'];
?>
<html>
    <head>
        <?php include('../view/frontHead.php')?>
        </style>
    </head>
    <body>
        <header>
            <?php include('../view/frontHeader.php')?>
        </header>
       <main>
            <?php echo $error; 
            if(!$session){
                exit;
            }?>
            <form action="createUser.php" method="post">
                <label for="first">First Name:</label>
                <input type="text" name="first" id="first"><br>
                <label for="last">Last Name:</label>
                <input type="text" name="last" id="last"><br>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo $user['email']?>"><br>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password"><br>
                <label for="confirm">Confirm Password:</label>
                <input type="password" name="confirm" id="confirm"><br>
                <input type="submit" value="Submit">
            </form>
        <main>
    </body>
</html>