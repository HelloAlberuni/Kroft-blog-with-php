<?php
ob_start();
session_start();
if(!isset($_SESSION['name'])){
	header('location:login.php');
}

include('../config.php');

if(isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
}
else {
	header('location:post-view.php');
}


$statement1 = $db->prepare("SELECT * FROM tbl_post WHERE post_id=?");
$statement1->execute(array($id));

$result = $statement1->fetchAll();
foreach($result as $row) {
	$image_name = $row['featured_image'];	
}
$path = "../uploads/".$image_name;
unlink($path);

$statement = $db->prepare("DELETE FROM tbl_post WHERE post_id=?");
$statement->execute(array($id));

header('location:post-view.php');


?>