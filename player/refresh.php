<?php require_once('../require.php');

$list = filter_input(INPUT_POST, 'listId', FILTER_VALIDATE_INT);

$query = 'SELECT ytVideoID, videoTitle, videoChannel, startSeconds, endSeconds FROM approved WHERE videoList = :id';
$statement = $db->prepare($query);
$statement->bindValue(':id', $list);
$statement->execute();
$videos = $statement->fetchAll();
$statement->closeCursor();
/*
$string = '';
foreach($videos as $video){
    $string .=  $video['ytVideoID'].'&&';
}
$string = substr($string, 0, strlen($string) - 2).'|';
foreach($videos as $video){
    $string .= $video['videoTitle'].'&&';
}
$string = substr($string, 0, strlen($string) - 2).'|';
foreach ($videos as $video){
    $string .= $video['videoChannel'].'&&';
}
$string = substr($string, 0, strlen($string) - 2).'|';
foreach ($videos as $video){
    $string .= $video['startSeconds'].'&&';
}
$string = substr($string, 0, strlen($string) - 2).'|';
foreach ($videos as $video){
    $string .= $video['endSeconds'].'&&';
}
$string = substr($string, 0, strlen($string) - 2);

echo $string;
*/
echo json_encode($videos);