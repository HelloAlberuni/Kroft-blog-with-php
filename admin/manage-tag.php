<?php
ob_start();
session_start();
if(!isset($_SESSION['name'])){
	header('location:login.php');
}
include('../config.php');
if(isset($_POST['tag_add'])){
	try{
		if(empty($_POST['tag_name'])){
			throw new Exception('Category Name Can not be empty');
		}
		
		$statement = $db->prepare("SELECT * FROM tbl_tag WHERE tag_name=?");
		$statement->execute(array($_POST['tag_name']));
		$result = $statement->rowcount();
		
		if($result>0){
			throw new exception('The tag already exist!');
		}
		
		$statement = $db->prepare("INSERT INTO tbl_tag (tag_name) values (?)");
		$statement->execute(array($_POST['tag_name']));
		
		$success_message = "Tag has been inserted successfully";
	}
	catch(Exception $e) {
		$err_message = $e->getMessage();
	}
}

if(isset($_POST['update_tag'])){
	try{
		if(empty($_POST['tag_name'])){
			throw new exception('Tag name can not be empty');
		}
		
		$statement = $db->prepare("UPDATE tbl_tag SET tag_name=? WHERE tag_id=?");
		$statement->execute(array($_POST['tag_name'],$_POST['hdn']));
		
		$success_message1 = "Tag Name updated successfully";
	}
	catch(Exception $e) {
		$err_message1 = $e->getMessage();
	}
}

if(isset($_REQUEST['id'])){
	$id = $_REQUEST['id'];
	$statement = $db->prepare("DELETE FROM tbl_tag WHERE tag_id=?");
	$statement->execute(array($id));
	
	$success_message2 = "Tag has been deleted successfully!";
}

?>
<?php include('header.php'); ?>
		<div class="content fix">
			<h3>Add new Tag</h3>
			<?php
			if(isset($err_message)){
				echo '<p class="error">'.$err_message.'</p>';
			}
			if(isset($success_message)){
				echo '<p class="success">'.$success_message.'</p>';
			}
			?>
			<form action="" method="post">
				<table>
					<tr>
						<td>Tag Name :</td>
						<td><input type="text" name="tag_name" /></td>
					</tr>
					<tr>
						<td><input type="submit" value="Add" name="tag_add" /></td>
					</tr>
				</table>
			</form>
			<div class="table_list fix">
				<h3>View All Tags</h3>
				<?php	
					if(isset($success_message2)){
						echo '<p class="success">'.$success_message2.'</p>';
					}
				?>
				<table width="100%">
					<tr>
						<th width="3%">Serial</th>
						<th width="80%">Tag Name</th>
						<th width="20%">Action</th>
					</tr>
					
					<?php
						$statement = $db->prepare("SELECT * FROM tbl_tag");
						$statement->execute();
						$result = $statement->fetchAll();
						
						$i = 0;
						foreach($result as $row){
						$i++;
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $row['tag_name']; ?></td>
						<td>
							<a href="#pp-<?php echo $i; ?>" rel="prettyPhoto[inline]">Edit</a>
							<div  id="pp-<?php echo $i; ?>" style="display:none">
								<form action="" method="post">
									<input type="hidden" name="hdn" value="<?php echo $row['tag_id']; ?>"/>
									<table>
										<tr>
											<td>Edit Data: <br /><br /></td>
											<?php
											if(isset($err_message1)){
												echo '<center><p class="error">'.$err_message1.'</p></center>';
											}
											if(isset($success_message1)){
												echo '<center><p class="success">'.$success_message1.'</p></center>';
											}
											?>
										</tr>
										<tr>
											<td><input type="text" name="tag_name" value="<?php echo $row['tag_name']; ?>" /></td>
										</tr>
										<tr>
											<td><input type="submit" value="Update" name="update_tag" /></td>
										</tr>
									</table>
								</form>
							</div>
							| 
							<a onclick="return confirm_delete();" href="manage-tag.php?id=<?php echo $row['tag_id']; ?>">Delete</a>
						</td>
					</tr>
					<?php
					}
					?>

				</table>
			</div>
		</div>
<?php include('footer.php'); ?>
