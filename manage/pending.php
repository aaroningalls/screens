<?php 
require_once('../require.php');

loggedIn('/manage/pending.php');
if(!isset($error)){
    $error = '';
}
$query = 'SELECT videoTitle, submissionId, videoChannel, submitName FROM pending WHERE isApproved = 0';
$statement = $db->prepare($query);
$statement->execute();
$videos = $statement->fetchAll();
$statement->closeCursor();

?>

<html>
    <head>

    </head>
    <body>
        <header>

        </header>
        <main>
            <h1>Pending Videos</h1>
            <?php echo $error ?>
            <table>
                <?php foreach($videos as $video):?>
                    <tr>
                        <td><a href="video.php?id=<?php echo $video['submissionId']?>"><?php echo $video['videoTitle']?></td>
                        <td><?php echo $video['videoChannel']?></td>
                        <td><?php echo $video['submitName']?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </main>
    </body>
</html>