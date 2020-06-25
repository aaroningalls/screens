<?php require_once('../require.php');
loggedIn();
if(!isset($error)){
    $error ='';
    $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if(!$id){
        $error = '<p class="error">The input was not as expected. Please try again.</p>';
        include('pending.php');
        exit;
    }
}
$sort = filter_input(INPUT_GET, 'sort', FILTER_VALIDATE_INT);
$query = 'SELECT * FROM pending WHERE submissionId = :id';
$statement = $db->prepare($query);
$statement->bindValue(':id', $id);
$statement->execute();
$video = $statement->fetch();
$statement->closeCursor();

$title = $video['videoTitle'];
$channel = $video['videoChannel'];

if($video['isApproved'] == 1){
    $query = 'SELECT videoTitle, videoChannel, approvedBy FROM approved WHERE dbVideoID = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $info = $statement->fetch();
    $statement->closeCursor();

    $query = 'SELECT firstName, lastName FROM users WHERE userId = :id';
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $info['approvedBy']);
    $statement->execute();
    $approvedBy = $statement->fetch();
    $statement->closeCursor();

    $title = $info['videoTitle'];
    $channel = $info['videoChannel'];
    $approved = true;
} else {
    $approved = 0;
}
$headerText = "Video Information";
$active = 1;
?>

<html>
    <head>
        <title>Review Submission</title>
        <?php include('../view/backHead.php')?>
        </style>
    </head>
    <body>
        <?php include('../view/backHeader.php')?>
        <main>
            <a href="index.php?sort=<?php echo $sort?>">&lt;&lt;Back</a><br>
            <?php echo $error ?>
            <h1>Review Submission</h1>
            <h3><?php echo $video['videoTitle']?> (<?php echo $video['videoChannel']?>)</h3>
            <form action="approve.php" method="post">
                <div class="grid-container">
                    <label>Submitted by:</label>
                    <input type="text" value="<?php echo $video['submitName'];?> (<?php echo $video['submitEmail'];?>)" disabled>
                    <label for="title">Display Title:</label>
                    <input type="text" id="title" name="title" value="<?php echo $title?>">
                    <label for="channel">Display Channel:</label>
                    <input type="text" id="channel" name="channel" value="<?php echo $channel;?>">
                    <label>Video Link:</label>
                    <label><a href="<?php echo $video['videoURL'];?>" target="_blank"><?php echo $video['videoURL'];?></a></label>
                    <?php if($video['isApproved'] == 1):?>
                        <label>Approved By:</label>
                        <input type="text" value="<?php echo $approvedBy['firstName'].' '.$approvedBy['lastName']?>" disabled>
                    <?php endif; ?>
                </div>
                <input type="radio" name="approval" value="1" checked><label>Approve</label>
                <input type="radio" name="approval" value="2"> <label>Reject</label><br>
                <input type="hidden" name="submissionId" value="<?php echo $video['submissionId'];?>">            
                    <ul class="buttons">
                        <li><input type="submit" value="SUBMIT"></li>
                        <li><input type="reset" value="DELETE" id="openModal"></li>
                    </ul>
                
            </form>
            <div class="modal">
                <div class="modalContent">
                <span class="close">&times;</span>
                    <div class="modalHeader">
                        <h2>Are you sure?</h2>
                    </div>
                    <div class="modalMain">
                        <p>Deleting the video can not be undone</p>
                    </div>
                    <div class="modalFooter">
                        <form action="deleteVideo.php" method="post">
                            <input type="hidden" value="<?php echo $video['submissionId']?>" name="id" id="id">
                            <input type="hidden" value="<?php echo $approved ?>" name="approved"id="approved">
                            <ul class="buttons">
                                <li><input type="submit" value="Delete"></li>
                                <li><input type="button" value="Cancel" class="close"></li>
                            </ul>
                        </form>
                    </div>
                </div>
            </div>

        </main>
    </body>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"   integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="   crossorigin="anonymous"></script>
    <script src="../js/main.js"></script>
    <script src="../js/modal.js"></script>
</html>
