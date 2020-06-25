<?php require_once('../require.php');
loggedIn();
$list = filter_input(INPUT_POST, 'list', FILTER_VALIDATE_INT);

if(!$list){
    $error = '<p>The list is invalid</p>';
    include('index.php');
    exit;
}
$query = 'SELECT ytVideoID FROM approved LIMIT 1';
$statement = $db->prepare($query);
$statement->execute();
$id = $statement->fetch();
$statement->closeCursor();

?>
<html>
<body>
    <head>
        <link rel="stylesheet" type="text/css" href="../styles/player.css">
    </head>
    <iframe id="player" src="https://www.youtube.com/embed/<?php echo $id['ytVideoID']?>?enablejsapi=1"></iframe>
    <section id="overlay">
        <h2 id="overTitle"></h2>
        <p id="overChannel"></p>
    </section>
</body>
<script   src="https://code.jquery.com/jquery-3.4.1.min.js"   integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="   crossorigin="anonymous"></script>
<script> 
    var id = <?php echo $list?>;
</script>
<script src="../js/player.js"></script>
</html>
