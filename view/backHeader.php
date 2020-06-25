
<html>
    <header>
        <img id="logo" src="../logo.png">
        <h1><?php echo $headerText?></h1>
    </header><br>
    <nav id="Hnav">
        <ul>
            <li><a href="../manage/" <?php if($active == 1){echo 'class="active"';}?>>Videos</a></li>
            <li><a href="../account/" <?php if($active == 2){echo 'class="active"';}?>>Account</a></li>
            <?php if ($_SESSION['privilege'] >= 1):?>
                <li><a href="../account/users.php" <?php if($active == 3){echo 'class="active"';}?>>Edit Users</a></li>
            <?php endif; ?>
            <li class="sideIcons"><a href="../account/logout.php"><img src="../logout.png"></a></li>
            <li class="sideIcons"><a href="../player/"><img src="../play.png"></a></li>
        </ul>
    </nav>
</html> 