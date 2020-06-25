<?php require_once('../require.php');
loggedIn();
if(!isset($error)){
    $error = '';
}

if($_SESSION['privilege'] == 0){
    $error = '<p class="error">You do not have access to edit users</p>';
    include('users.php');
    exit;
}
if(!isset($user)){
    $user = filter_input(INPUT_POST, 'userId', FILTER_VALIDATE_INT);
    if(!$user){
        $error = '<p class="error">The input was unexpected. Please try again</p>';
        include('users.php');
        exit;
    }
}
$query = 'SELECT * FROM users WHERE userId = :id';
$statement = $db->prepare($query);
$statement->bindValue(':id', $user);
$statement->execute();
$user = $statement->fetch();
$statement->closeCursor();

$query = 'SELECT * FROM userTypes';
$statement = $db->prepare($query);
$statement->execute();
$types = $statement->fetchAll();
$statement->closeCursor();

if($user['privilege'] >= $_SESSION['privilege'] && $_SESSION['privilege'] != 3){
    $error = '<p class="error">You do not have the privilege to edit this user</p>';
    include('users.php');
    exit;
}
$headerText = 'Edit User';
$active = 3;
?>
<html>
    <head>
        <title>Edit User</title>
        <?php include('../view/backHead.php') ?>
        </style>
    </head>
    <body>
        <?php include('../view/backHeader.php')?>
       <main>       
            <?php echo $error ?>
            <form action="edit.php" method="post">
                <div class="grid-container">
                <label for="firstName">First Name:</label>
                <input type="text" name="firstName" id="firstName" value="<?php echo $user['firstName']?>">
                <label for="lastName">Last Name:</label>
                <input type="text" name="lastName" id="lastName" value="<?php echo $user['lastName']?>">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="<?php echo $user['email']?>">
                <label for="privilege">User Type:</label>
                <div class="select">
                    <select name="privilege" id="privilege">
                        <?php foreach($types as $type):?>
                        <?php if($type['typeId'] > $_SESSION['privilege']){break;}?>
                        <option value="<?php echo $type['typeId']?>" <?php if($user['privilege'] == $type['typeId']){echo 'selected';}?>>
                        <?php 
                        if($type['typeId'] == 3){
                            echo 'Super '.ucfirst($type['typeTitle']);
                        } else {
                            echo ucfirst($type['typeTitle']);
                        }?>
                    </option>
                    <?php endforeach ?>
                    </select>
                </div><br>
                </div>
                <input type="hidden" name="userId" id="userId" value="<?php echo $user['userId']?>">
                <input type="submit" value="Submit">
                <input type="button" value="Delete" id="openModal">   
            </form>
            <div class="modal">
                <div class="modalContent">
                    <span class="close">&times;</span>
                    <div class="modalHeader">
                        <h2>Are you sure?</h2>
                    </div>
                    <div class="modalMain">
                        Deleting a user can not be undone
                    </div>
                    <div class="modalFooter">
                        <form action="deleteUser" method="post">
                            <input type="hidden" name="userId" id="userId" value="<?php echo $user['userId']?>">
                            <input type="submit" value="Delete">
                            <input type="button" value="Cancel" class="close">
                        </form>
                    </div>
                </div>
            </div>
       </main>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"   integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="   crossorigin="anonymous"></script>
        <script src="../js/modal.js"></script>
        <script src="../js/fancySelect.js"></script>
    </body>
</html>