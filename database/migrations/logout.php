<?php
include '../migrations/users.php';
$new = new Users();
$new->createTable();
var_dump($new->Logout());
?>