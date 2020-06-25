<?php 

require_once('../require.php');

if(!isset($_SESSION['path'])){
    $_SESSION['path'] = 'index.php';
}
if(!isset($error)){
    $error = '<br>';
}
$headerText = 'Login';
?>

<html>
    <head>
        <title>Login</title>
        <?php include('../view/frontHead.php') ?>
        </style>
    </head>
    <body>
        <?php include('../view/frontHeader.php') ?>
        <main>
            <?php echo $error?>
            <form action="/account/login.php" method="post">
                <div class="grid-container">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password">
                </div>
                <ul class="buttons">
                    <li><input type="submit" value="Login"></li>
                </ul>
            </form>
            <a href="forgot.php">Forgot password?</a>
        </main>
    </body>
</html>