<?php
ob_start();
session_start();
if(!isset($_SESSION['name'])){
	header('location:login.php');
}
include('../config.php');
if(isset($_POST['category_add'])){
	try{
		if(empty($_POST['cat_name'])){
			throw new Exception('Category Name Can not be empty');
		}
		
		$statement = $db->prepare("SELECT * FROM tbl_category WHERE cat_name=?");
		$statement->execute(array($_POST['cat_name']));
		$result = $statement->rowcount();
		
		if($result>0){
			throw new exception('The category already exist!');
		}
		
		$statement = $db->prepare("INSERT INTO tbl_category (cat_name) values (?)");
		$statement->execute(array($_POST['cat_name']));
		
		$success_message = "Category has been inserted successfully";
	}
	catch(Exception $e) {
		$err_message = $e->getMessage();
	}
}

if(isset($_POST['update_cat'])){
	try{
		if(empty($_POST['cat_name'])){
			throw new exception('Category name can not be empty');
		}
		
		$statement = $db->prepare("UPDATE tbl_category SET cat_name=? WHERE cat_id=?");
		$statement->execute(array($_POST['cat_name'],$_POST['hdn']));
		
		$success_message1 = "Category Name updated successfully";
	}
	catch(Exception $e) {
		$err_message1 = $e->getMessage();
	}
}

if(isset($_REQUEST['id'])){
	$id = $_REQUEST['id'];
	$statement = $db->prepare("DELETE FROM tbl_category WHERE cat_id=?");
	$statement->execute(array($id));
	
	$success_message2 = "Category has been deleted successfully!";
}

?>
<?php include('header.php'); ?>
		<div class="content fix">
			<h3>Add new Category</h3>
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
						<td>Category Name :</td>
						<td><input type="text" name="cat_name" /></td>
					</tr>
					<tr>
						<td><input type="submit" value="Update" name="category_add" /></td>
					</tr>
				</table>
			</form>
			<div class="table_list fix">
				<h3>View All Categories</h3>
				<?php	
					if(isset($success_message2)){
						echo '<p class="success">'.$success_message2.'</p>';
					}
				?>
				<table width="100%">
					<tr>
						<th width="3%">Serial</th>
						<th width="80%">Category Name</th>
						<th width="20%">Action</th>
					</tr>
					
					<?php
						$statement = $db->prepare("SELECT * FROM tbl_category");
						$statement->execute();
						$result = $statement->fetchAll();
						
						$i = 0;
						foreach($result as $row){
						$i++;
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $row['cat_name']; ?></td>
						<td>
							<a href="#pp-<?php echo $i; ?>" rel="prettyPhoto[inline]">Edit</a>
							<div  id="pp-<?php echo $i; ?>" style="display:none">
								<form action="" method="post">
									<input type="hidden" name="hdn" value="<?php echo $row['cat_id']; ?>"/>
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
											<td><input type="text" name="cat_name" value="<?php echo $row['cat_name']; ?>" /></td>
										</tr>
										<tr>
											<td><input type="submit" value="Update" name="update_cat" /></td>
										</tr>
									</table>
								</form>
							</div>
							| 
							<a onclick="return confirm_delete();" href="manage-category.php?id=<?php echo $row['cat_id']; ?>">Delete</a>
						</td>
					</tr>
					<?php
					}
					?>

				</table>
			</div>
		</div>
<?php include('footer.php'); ?>
