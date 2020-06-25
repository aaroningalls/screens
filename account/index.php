<?php 
require_once('../require.php');

loggedIn();

$query = 'SELECT firstName, lastName, email, privilege FROM users WHERE userId = :id';
$statement = $db->prepare($query);
$statement->bindValue(':id', $_SESSION['user']);
$statement->execute();
$user = $statement->fetch();

if(!isset($error)){
    $error = '';
}

if(!isset($passwordFail)){
    $passwordFail = false;
}
$headerText = 'Account';
$active = 2;
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include('../view/backHead.php') ?>
        </style>
    </head>
    <body>
        <?php include("../view/backHeader.php") ?>
    <h1>Welcome <?php echo($user['firstName'].' '.$user['lastName'])?></h1>
        <main>
            <p>Change email</p><br>
                <br>
                <?php echo $error;?>
                <form action="changeEmail.php" method="post">
                    <div class="grid-container">
                        <label>Current Email: </label>
                        <input type="email" value="<?php echo $user['email']?>" disabled>
                        <label for="newEmail">New Email: </label>
                        <input type="email" name="newEmail" id="newEmail">
                        <label for="confirmEmail">Confirm Email: </label>
                        <input type="email" name="confirmEmail" id="confirmEmail">
                    </div>
                    <ul class="buttons">
                        <li><input type="submit" value="SUBMIT"></li>
                    </ul>
                </form>
            <p>Change Password</p><br>
           
                <br>
                <?php if($passwordFail){echo $error;}?>
                <form action="changePassword.php" method="post">
                    <div class="grid-container">
                        <label for="curPassword">Current Password: </label>
                        <input type="password" id="curPassword" name="curPassword">
                        <label for="newPassword">New Password: </label>
                        <input type="password" id="newPassword" name="newPassword">
                        <label for="confirmPassword">Confirm Password: </label>
                        <input type="password" id="confirmPassword" name="confirmPassword">
                    </div>
                    <ul class="buttons">
                        <li><input type="submit" value="SUBMIT"></li>
                    </ul>
                </form>
        </main>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){

            })
        </script>
    </body>
</html>
