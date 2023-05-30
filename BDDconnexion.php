<?php
$database = "ECE_In";
$db_handle = mysqli_connect('localhost', 'root', '', $database);

$db_found = mysqli_select_db($db_handle, $database);
mysqli_set_charset($db_handle, 'utf8');