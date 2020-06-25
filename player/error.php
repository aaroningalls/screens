<?php require_once('../require.php');

$code = filter_input(INPUT_POST, 'code', FILTER_VALIDATE_INT);
$id = filter_input(INPUT_POST, 'id');

if(!$id || !$code){
    exit;
}
$id = htmlspecialchars($id, ENT_QUOTES);
$date = date('Y-m-d H:i:s');

$query = 'INSERT INTO errors (errorCode, videoId, errorDate) VALUES (:code, :id, :date)';
$statement = $db->prepare($query);
$statement->bindValue(':code', $code);
$statement->bindValue(':id', $id);
$statement->bindValue(':date', $date);
$statement->execute();
$statement->closeCursor();



