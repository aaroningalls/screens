<?php
$file = filter_input(INPUT_POST, "file");
$json = fopen("shops.json", "w");
fwrite($json, $file);
fclose($json);