<?php
include '../migrations/users.php';
$new = new Users();
$new->createTable();
echo $new->registerUser($_POST);

?>