<?php

    $dsn = 'mysql:host=localhost;dbname=videos';
    $username = 'admin';
    $password = 'adminpassword';

    try {
        $db = new PDO($dsn, $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        include('dberror.php');
        exit();
    }
?>