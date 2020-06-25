<?php  require_once('../require.php');
loggedIn();

$sort = filter_input(INPUT_GET, 'sort', FILTER_VALIDATE_INT);
if(!$sort || ($sort < 0 || $sort > 2)){
    $sort = 0;
}
 if($sort == 0){
     $query = 'SELECT videoTitle, submissionId, videoChannel, submitName FROM pending WHERE isApproved = 0';
 } else if ($sort == 1){
     $query = 'SELECT videoTitle, submissionId, videoChannel, submitName FROM pending WHERE isApproved = 1';
 } else {
     $query = 'SELECT videoTitle, submissionId, videoChannel, submitName, isApproved FROM pending';
 }
 $statement = $db->prepare($query);
 $statement->execute();
 $videos = $statement->fetchAll();
 $statement->closeCursor();

 $headerText = 'Manage Videos';
 $active = 1;
?>

<html>
    <head>
        <title>Manage</title>
        <?php include('../view/backHead.php') ?>
        </style>
    </head>
    <body>
        <?php include('../view/backHeader.php')?>
        <main>
            <nav id="sortNav">
                <ul>
                    <li><a href="index.php?sort=0" <? if ($sort == 0){echo 'class="activeSort"';}?>>Pending Videos</a></li>
                    <li><a href="index.php?sort=1" <? if ($sort == 1){echo 'class="activeSort"';}?>>Approved Videos</a></li>
                    <li><a href="index.php?sort=2" <? if ($sort == 2){echo 'class="activeSort"';}?>>All Videos</a></li>
                </ul>
            </nav>
            <?php if (!$videos):
                if ($sort == 0) {
                    $type = 'pending ';
                } else if ($sort == 1){
                    $type = 'approved ';
                } else if ($sort == 2){
                    $type = '';
                }?>
                <p>There were no <?php echo $type ?>videos found.</p>
                
            <?php else: ?>
            <table>
                <tr>
                    <th>Video Title</th>
                    <th>Video Channel</th>
                    <th>Submitted By</th>
                    <?php if($sort == 2){
                        echo '<th>Approved</th>';
                    } ?>
                </tr>
                <?php foreach($videos as $video): ?>
                <tr>
                    <td><a href="video.php?id=<?php echo $video['submissionId'];?>&sort=<?php echo $sort?>"><?php echo $video['videoTitle']?></a></td>
                    <td><?php echo $video['videoChannel']?></td>
                    <td><?php echo $video['submitName']?></td>
                    <?php if($sort == 2){
                        if($video['isApproved'] == 0){
                            $approved = 'No';
                        } else {
                            $approved = 'Yes';
                        }
                        echo '<td>'.$approved.'</td>';
                    } ?>
                </tr>
                <?php endforeach ?>
            </table>
                <?php endif; ?>
        </main>
    </body>
    <script   src="https://code.jquery.com/jquery-3.4.1.min.js"   integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="   crossorigin="anonymous"></script>
</html>