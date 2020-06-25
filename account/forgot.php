<?php $headerText = 'Password Reset'?>

<html>
    <head>
        <title>Password Reset</title>
        <?php include('../view/frontHead.php')?>
        <style>
            .grid-container {
                grid-template-columns: 10% 40%;
            }
            .buttons {
                margin: 0 25%;
            }
        </style>
    </head>
    <body>
       <?php include('../view/frontHead.php')?>
       <main>
           <?php include('../view/frontHeader.php') ?>
            <h1>Forgot your password</h1>
            <p>Enter your email below and a link will be sent to reset your password</p>
            <form action="sendForgot.php" method="post">
                <div class="grid-container">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email">
                </div>
                <ul class="buttons">
                    <li>
                        <input type="submit" value="Submit">
                    </li>
                </ul >
            </form>
        </main>
    </body>
</html>