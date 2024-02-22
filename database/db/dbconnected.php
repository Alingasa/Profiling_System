<?php
include '../db/db.php';
header('Content-type: application/json; charset=UTF-8');
$new = new Db();
echo $new->db_connection();  
?>