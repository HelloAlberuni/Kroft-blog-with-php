<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>login page</title>
	<link rel="stylesheet" href="../style-admin.css" />
	
	<script type="text/javascript" src="../jquery-1.10.2.min.js"></script>
	<script type="text/javascript" src="../prettyphoto/js/jquery.prettyPhoto.js"></script>
	<script type="text/javascript" src="../ckeditor/ckeditor.js"></script>
	<link rel="stylesheet" href="../prettyphoto/css/prettyPhoto.css" />
	
	<script type="text/javascript">
		function confirm_delete(){
			return confirm('Do you want to delete this data');
		}
	</script>
	
</head>
<body>
	<div class="wrapper fix">
		<div class="header fix">
			<h1>Admin panel Dashboard</h1>
		</div>
		<div class="sidebar fix">
			<div class="single_sidebar fix">
				<h2>Page options</h2>
				<ul>
					<li><a href="index.php">Home</a></li>
					<li><a href="change-footer-text.php">Change Footer Text</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
			</div>
			<div class="single_sidebar fix">
				<h2>Blog options</h2>
				<ul>
					<li><a href="post-add.php">Add Post</a></li>
					<li><a href="post-view.php">View Post</a></li>
					<li><a href="manage-category.php">Manage Category</a></li>
					<li><a href="manage-tag.php">Manage Tags</a></li>
				</ul>
			</div>
			<div class="single_sidebar fix">
				<h2>Comment options</h2>
				<ul>
					<li><a href="comment-view.php">View Comments</a></li>
				</ul>
			</div>
		</div>