<?php
ob_start();
session_start();
if(!isset($_SESSION['name'])){
	header('location:login.php');
}
?>
<?php include('header.php'); ?>
		<div class="content fix">
			<h3>Welcome to admin panel</h3>
			<h2>Welcome to dashboard of -Kroft "blog with PHP"</h2>
		</div>
<?php include('footer.php'); ?>