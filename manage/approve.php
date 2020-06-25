<?php require_once('../require.php');

loggedIn('/manage/approve.php');

$approval = filter_input(INPUT_POST, 'approval', FILTER_VALIDATE_INT);
$id = filter_input(INPUT_POST, 'submissionId', FILTER_VALIDATE_INT);
$title = filter_input(INPUT_POST, 'title');
$channel = filter_input(INPUT_POST, 'channel');

if(!$approval || !$id || ($approval != 1 && $approval != 2)){
    $error = '<p class="error">The input was not as expected. Please refresh the page and try again</p>';
    include('video.php');
    exit;
} else if(!$title || !$channel){
    $error = '<p class="error">One or more fields are invalid</p>';
    include('video.php');
    exit;
}

if ($approval == 1){
    $query = 'SELECT videoURL, videoTitle, videoChannel, videoList FROM pending WHERE submissionId = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $video = $statement->fetch();
    $statement->closeCursor();

    if(strpos($video['videoURL'], 'v=') === false){
        $error = '<p class="error">The YouTube video ID could not be found</p>';
        include('video.php');
        exit;
    } else {
        $ytID = substr($video['videoURL'], strpos($video['videoURL'], 'v=') + 2);
        if (strpos($ytID, '&') !== false){
            $ytID = substr($ytID, 0, strpos($ytID, '&'));
        }
    }
    if(preg_match('([^A-Za-z0-9]+)', $ytID) || strlen($ytID) > 11){
        $error = '<p class="error">The YouTube video ID is invalid</p>';
        include('video.php');
        exit;
    }
    $query = 'SELECT videoID FROM approved WHERE dbVideoID = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $vidId = $statement->fetch();
    $statement->closeCursor();

    if(!empty($vidId)){
        $query = 'UPDATE approved videoTitle = :title, videoChannel = :channel';
    } else {
        $query = 'INSERT INTO approved (ytVideoID, dbVideoID, videoTitle, videoChannel, videoList, approvedBy)
              VALUES (:ytId, :dbId, :title, :channel, :list, :user)';
        $statement = $db->prepare($query);
        $statement->bindValue(':ytId', $ytID);
        $statement->bindValue(':dbId', $id);
        $statement->bindValue(':title', $title);
        $statement->bindValue(':channel', $channel);
        $statement->bindValue(':list', $video['videoList']);
        $statement->bindValue(':user', $_SESSION['user']);
        $statement->execute();
        $statement->closeCursor();

        $query = "UPDATE pending SET isApproved = 1 WHERE submissionId = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $statement->closeCursor();
    }
    include('index.php');
} else {
    $query = 'SELECT videoID FROM approved WHERE dbVideoID = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $video = $statement->fetch();
    $statement->closeCursor();

    if(!empty($video)){
        $query = 'DELETE FROM approved WHERE videoID = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $video['videoID']);
        $statement->execute();
        $statement->closeCursor();

        $query = 'UPDATE pending SET isApproved = 0 WHERE submissionId = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $statement->closeCursor();
        include('index.php');
    }
}