<?php
if(isset($_POST['login_form'])){
	try{
		if(empty($_POST['username'])){
			throw new Exception('Username Can not be empty');
		}
		
		if(empty($_POST['password'])){
			throw new Exception('Password Can not be empty');
		}
		
		$password = $_POST['password'];
		$password = md5($_POST['password']);
		
		include('../config.php');
		
		$statement = $db->prepare("SELECT * FROM tbl_login WHERE username=? and password=?");
		$statement->execute(array($_POST['username'],$password));
		
		$result = $statement->rowCount();
		if($result>0){
			session_start();
			$_SESSION['name'] = $_POST['username'];
			header('location:index.php');
		}
	}
	catch(Exception $e) {
		$err_message = $e->getMessage();
	}
}
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>login page</title>
	<link rel="stylesheet" href="../style-admin.css" />
</head>
<body>
	<form class="login_form" action="" method="post">
		<h2>Login Here</h2>
		<?php
		if(isset($err_message)){
			echo '<center><p class="error">'.$err_message.'</p></center>';
		}
		?>
		<table>
			<tr>
				<td>Username :</td>
				<td><input type="text" name="username" id="" /></td>
			</tr>
			<tr>
				<td>Password :</td>
				<td><input type="password" name="password" id="" /></td>
			</tr>
			<tr>
				<td><input type="submit" value="Login" name="login_form" /></td>
			</tr>
		</table>
	</form>
</body>
</html>