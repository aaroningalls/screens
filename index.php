<?php 
$index = true;
require_once('require.php');

$query = 'SELECT * FROM lists';
$statement = $db->prepare($query);
$statement->execute();
$list = $statement->fetchAll();
$statement->closeCursor();

if(!isset($error)){
    $error = '';
}
$headerText = 'Submit a Video';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Video Submission</title>
        <?php include('view/frontHead.php') ?>
        </style>
    </head>
    <body>
            <?php include('view/frontHeader.php')?>
        <main>
            <p>Have a video about a project or a cool video about some tech thing? Fill out the form below to submit a video to be played on the screens around campus. Once submitted the video will be reviewed by staff or faculty. 
                Currently videos can only be played on the main Beacom screen, but more will be added in the future. Videos must be publicly (unlisted is allowed) uploaded to YouTube and allow embedding.  
            </p>
            <?php echo $error ?>
            <form action="submission.php" method="POST" novalidate>
                <div class="grid-container">
                    <label for="first">First Name:</label>
                    <input type="text" id="first" name="first" required autofocus>
                    <label for="last">Last Name:</label> 
                    <input type="text" id="last" name="last" required>
                    <label for="email">DSU Email:</label>
                    <input type="email" id="email" name="email" pattern="([A-Za-z0-1\.]+@trojans.dsu.edu|@dsu.edu)" placeholder="example@trojans.dsu.edu" required>
                    <label for="title">Video Title:</label>
                    <input type="text" id="title" name="title" required>
                    <label for="channel">Channel:</label>
                    <input type="text" id="channel" name="channel" required>
                    <label for="url">Video URL:</label>
                    <input type="url" id="url" name="url" placeholder="youtube.com/watch?v=5QRv05hAzLQ" required>
                    <label for="time">Designate Time?</label>
                    <div class="timeGrid">
                        <label class="check">
                            <input type="checkbox" name="time" id="time">
                            <span class="checkmark"></span>
                        </label>
                        <div id="timeInput">   
                            <input type="text" name="startSeconds" id="startSeconds" placeholder="Start (h:m:s)" pattern="([0-9]{1,}:[0-9]{1,2}:[0-9]{1,2})">
                            <input type="text" name="endSeconds" id="endSeconds" placeholder="End (h:m:s)" pattern="([0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2})"> 
                        </div>
                    </div>
                        </div>
                        <div class="select">
                            <select id="list" name="list">
                                <option value="0">Select Video List:</option>
                                <?php
                                    foreach($list as $title){
                                        echo '<option value="'.$title['listID'].'">'.$title['listTitle'].'</option>\n';
                                    }
                                ?>
                            </select>
                        </div>
                        <span class="after"></span>
                <br>
                <ul class="buttons">
                    <li><input type="submit" value="SUBMIT" id="submit"></li>
                </ul>
            </form>
        </main>
    </body>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"   integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="   crossorigin="anonymous"></script>
    <script src="js/index.js"></script>
    <script src="js/fancySelect.js"></script>
    <script src="js/form.js"></script>
</html>