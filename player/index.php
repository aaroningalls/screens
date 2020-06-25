<?php require_once('../require.php');

loggedIn('/player');
if(!isset($error)){
    $error = '';
}

$query = 'SELECT * FROM lists';
$statement = $db->prepare($query);
$statement->execute();
$lists = $statement->fetchAll();
$statement->closeCursor();

?>

<html>
    <head>

    </head>
    <body>
        <header>

        </header>
        <main>
            <?php echo $error ?>
            <h1>Select List</h1>
            <form action="player.php" method="post">
                <label for="list">List: </label>
                <select name="list">
                    <?php foreach($lists as $item): ?>
                    <option value="<?php echo $item['listID'];?>"><?php echo $item['listTitle'];?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit">
            </form>
        </main>
    </body>
</html>