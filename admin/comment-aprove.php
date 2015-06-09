<?php
ob_start();
session_start();
if(!isset($_SESSION['name'])){
	header('location:login.php');	
}
include('../config.php');

if($_REQUEST['id']){
	$id = $_REQUEST['id'];
}
?>

<?php

	$statement= $db->prepare("UPDATE tbl_comment SET status=1 WHERE id=?");
	$statement->execute(array($id));
	
	echo "Aproved";
	header('location:comment-view.php');

?>