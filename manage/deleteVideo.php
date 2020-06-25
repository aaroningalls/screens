<?php require_once('../require.php');
loggedIn();

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$approved = filter_input(INPUT_POST, 'approved', FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
if(!$id || $approved === NULL){
    $error = '<p class="error">The input was not as expected. Please try again</p>';
    include('video.php');
    exit;
}
$query = 'DELETE FROM pending WHERE submissionId = :id';
$statement = $db->prepare($query);
$statement->bindValue(':id', $id);
$statement->execute();
$statement->closeCursor();

if($approved){
    $query = 'DELETE FROM approved WHERE dbVideoID = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $statement->closeCursor();
}
include('index.php');
