<?php require_once('../require.php');
loggedIn();

if(!isset($error)){
    $error = '';
}
  
if($_SESSION['privilege'] == 0){
    $error = '<p class="error">You do not have the privilege to access this page</p>';
    exit;
}

$query = 'SELECT * FROM users';
$statement = $db->prepare($query);
$statement->execute();
$users = $statement->fetchAll();
$statement->closeCursor();

$query = 'SELECT * FROM userTypes';
$statement = $db->prepare($query);
$statement->execute();
$types = $statement->fetchAll();
$statement->closeCursor();

$headerText = 'Manage Users';
$active = 3;
?>

<html>
    <head>
        <title></title>
        <?php include('../view/backHead.php') ?>
        </style>
    </head>
    <body>
        <?php include('../view/backHeader.php') ?>
        <main>
            <?php echo $error ?>
            <table>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Privilege</th>
                    <th></th>
                </tr>
                <?php foreach($users as $user):?>
                <tr>
                    <?php if($user['privilege'] > 3){
                        $user['privilege'] = 4;
                    }?>
                    <td><?php echo $user['firstName']?></td>
                    <td><?php echo $user['lastName']?></td>
                    <td><?php echo $user['email']?></td>
                    <td><?php echo ucfirst($types[$user['privilege']]['typeTitle'])?></td>
                    <td>
                        <form action="editUser.php" method="post">
                            <input name="userId" id="userId" type="hidden" value="<?php echo $user['userId']?>">
                            <input type="submit" value="Edit" <?php if($_SESSION['privilege'] <= $user['privilege'] && $_SESSION['privilege'] != 3){echo 'disabled';}?>>
                        </form>
                    </td>
                </tr>
                <?php endforeach?>
            </table>
            <h3>
                Add User
            </h3>
            <p>An email will be sent for the user to create a new account</p>
            <form action="newUser.php" method="post">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email"><br>
                <div class="select">
                    <select name="privilege" id="privilege">
                      <option value="0">User Privilege:</option>  
                      <?php foreach($types as $type):?>
                      <?php if($type['typeId'] >= $_SESSION['privilege']){break;}?>
                      <option value="<?php echo $type['typeId']+1?>">
                      <?php echo ucfirst($type['typeTitle'])?>
                    </option>
                    <?php endforeach ?>
                    </select>
                </div><br>
                <input type="submit">
            </form>
        </main>
    </body>
    <script src="../js/fancySelect.js"></script>
</html>

