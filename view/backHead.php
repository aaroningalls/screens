<html> 
    <link href="https://fonts.googleapis.com/css?family=Crimson+Text|Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../styles/main.css">
    <link rel="stylesheet" type="text/css" href="../styles/forms.css">
    <link rel="stylesheet" type="text/css" href="../styles/nav.css">
    <link rel="stylesheet" type="text/css" href="../styles/table.css">
        <style>
            main {
                border: none;
            }
    <?php if ($_SESSION['privilege'] >= 1): ?>
            #Hnav ul li {
                width: 23%;
            }
    <?php endif;?>  
