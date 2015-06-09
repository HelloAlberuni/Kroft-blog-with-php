<?php
ob_start();
session_start();
if(!isset($_SESSION['name'])){
	header('location:login.php');
}
include('../config.php');
?>

<?php

if(isset($_POST['change_footer_text'])) {
	
	try {
	
		if(empty($_POST['footer_text'])) {
			throw new Exception("Footer Text Can not be empty");
		}
		
		// $statement = $db->prepare("SELECT * FROM tbl_footer_text WHERE id=?");
		// $statement = $db->prepare("INSERT into tbl_footer_text WHERE id=?");
		// $statement->execute(array(2));
		// $result = $statement->rowCount();
		
		$statement1 = $db->prepare("UPDATE tbl_footer_text SET footer_text=?  WHERE id=3");
		$statement1->execute(array($_POST['footer_text']));
		
		$update_success = "Data Updated successfully";
	
		
		// if($result > 0) {
			// $statement1 = $db->prepare("UPDATE tbl_footer_text SET footer_text=?  WHERE id=2");
			// $statement1->execute(array($_POST['footer_text']));
			
			// $update_success = "Data Updated successfully";
		// }
		// else{
			// $statement1 = $db->prepare("INSERT INTO tbl_footer_text WHERE id=?");
			// $statement1->execute(array($_POST['footer_text']));
			
			// $insert_success = "Data inserted successfully";
		// }
		
	}
	catch(Exception $e) {
		$error_message = $e->getMessage();
	}
	
}

?>



<?php include('header.php'); ?>
		<div class="content fix">
			<h3>Change Footer Text</h3>
			<?php
			
			if(isset($error_message)) {
				echo '<p class="error">'.$error_message.'</p>';
			}
			if(isset($insert_success)){
				echo '<p class="success">'.$insert_success.'</p>';
			}
			
			if(isset($update_success)){
				echo '<p class="success">'.$update_success.'</p>';
			}
			
			?>
			<form action="" method="post">
			
			<?php
				$statement2 = $db->prepare("SELECT * FROM tbl_footer_text WHERE id=?");
				$statement2->execute(array(3));
				
				$result2 = $statement2->fetchAll();
				foreach($result2 as $row2) {
					$footer_text = $row2['footer_text'];
				}
			?>
			
				<table>
					<tr>
						<td>Footer Text :</td>
						<td><input class="mid" type="text" name="footer_text" value="<?php echo $footer_text; ?>" /></td>
					</tr>
					<tr>
						<td><input type="submit" value="Update Footer Text" name="change_footer_text" /></td>
					</tr>
				</table>
			</form>
		</div>
<?php include('footer.php'); ?>
