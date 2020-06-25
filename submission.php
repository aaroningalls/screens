<?php require_once('database/dbconnect.php');
$values = Array ();
$values['first'] = filter_input(INPUT_POST, 'first');
$values['last'] = filter_input(INPUT_POST, 'last');
$values['email'] = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$values['title'] = filter_input(INPUT_POST, 'title');
$values['channel'] = filter_input(INPUT_POST, 'channel');
$values['url'] = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
$list = filter_input(INPUT_POST, 'list', FILTER_VALIDATE_INT);

foreach($values as $key => $value){
    if(!$value){
        $error = '<p class="error">One or more fields are invalid</p>';
        include('index.php');
        exit;
    }
    $values[$key] = htmlspecialchars($value, ENT_QUOTES);
}
$query = 'INSERT INTO pending (submitName, submitEmail, videoTitle, videoChannel, videoURL, videoList)
          VALUES (:name, :email, :title, :channel, :url, :list)';
$statement = $db->prepare($query);
$statement->bindValue(':name', $values['first']." ".$values['last']);
$statement->bindValue(':email', $values['email']);
$statement->bindValue(':title', $values['title']);
$statement->bindValue((':channel'), $values['channel']);
$statement->bindValue(':url', $values['url']);
$statement->bindValue(':list', $list);
$statement->execute();
$statement->closeCursor();
$headerText = 'Thank You'
?>

<html>
    <head>
        <title>Submission Success</title>
    </head>
    <body>
       
        <?php include('view/frontHeader.php')?>
       
        <main>
            <h1>Thanks</h1>
            <p>The video has been successfully submitted and is pending approval. You can submit another video <a href="index.php">here</a> if you'd like.</p>
        </main>
    </body>
</html>

