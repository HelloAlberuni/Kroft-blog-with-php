<?php
ob_start();
session_start();
if(!isset($_SESSION['name'])){
	header('location:login.php');
}
include('../config.php');
?>



<?php
if(isset($_POST['post_add'])) {
	try{
		if(empty($_POST['post_title'])) {
			throw new Exception('Post name can not be empty');
		}
		
		if(empty($_POST['post_details'])) {
			throw new Exception('Post Description can not be empty');
		}
		
		if(empty($_POST['cat_id'])) {
			throw new Exception('Category name should selected at least one');
		}
		
		if(empty($_POST['tag_id'])) {
			throw new Exception('Tag name should selected at least one');
		}
		
		$post_title = $_POST['post_title'];
		$post_details = $_POST['post_details'];
		$cat_id = $_POST['cat_id'];
		$tag_ids = $_POST['tag_id'];
		$tag_ids = implode(",",$tag_ids);
		
		$post_date = date('d-m-Y');
		$post_month = substr($post_date,3,2);
		$post_year = substr($post_date,6,4);
		$post_timestamp = strtotime($post_date);
		
		$filename = $_FILES['featured_image']['name'];
		//$file_basename = substr($filename,0,strpos($filename,'.'));
		$file_ext = substr($filename,strpos($filename,'.'));

		if(($file_ext != ".jpg") && ($file_ext != ".png") && ($file_ext != ".jpeg") && ($file_ext != ".gif")){
			throw new Exception('Only jpeg / png / jpg and gif file allowed');
		}
		
		$statement = $db->prepare("SHOW TABLE STATUS LIKE 'tbl_post'");
		$statement->execute();
		$result = $statement->fetchAll();
		foreach($result as $row) {
			$new_id = $row['10'];
		}
		
		$new_filename = $new_id.$file_ext;

		move_uploaded_file($_FILES['featured_image']['tmp_name'],"../uploads/".$new_filename);
		
		$statement = $db->prepare("INSERT INTO tbl_post (post_title,post_details,featured_image,cat_id,tag_id,post_date,post_month,post_year,post_timestamp) values (?,?,?,?,?,?,?,?,?)");
		$statement->execute(array($post_title,$post_details,$new_filename,$cat_id,$tag_ids,$post_date,$post_month,$post_year,$post_timestamp));
		
		$success_message = "Post published successfully";
	}
	catch(Exception $e) {
		$err_message = $e->getMessage();
	}
}
?>

<?php include('header.php'); ?>
		<div class="content fix">
			<h3>Add Post</h3>
			<?php
			if(isset($err_message)){
				echo '<p class="error">'.$err_message.'</p>';
			}
			if(isset($success_message)){
				echo '<p class="success">'.$success_message.'</p>';
			}
			?>
			<form action="" method="post" enctype="multipart/form-data">
				<table>
					<tr><td>Post Name :</td></tr>
					<tr><td><input style="margin-bottom:5px" class="mid" type="text" name="post_title" value="" /></td></tr>
					<tr><td>Post Description :</td></tr>
					<tr>
					<td width="500px">
						<textarea name="post_details" id="" cols="50" rows="10"></textarea>
						<script>

							// This call can be placed at any point after the
							// <textarea>, or inside a <head><script> in a
							// window.onload event handler.

							// Replace the <textarea id="editor"> with an CKEditor
							// instance, using default configurations.

							CKEDITOR.replace( 'post_details' );

						</script>
					</td>
					</tr>
					<tr>
						<td><p><b>Upload featured image: </b></p></td>
					</tr>
					<tr>
						<td><p><input type="file" name="featured_image" id="" /></p></td>
					</tr>
					<tr>
						<td><b>Select A category</b></td>
					</tr>
					<tr>
						<td>
							<select name="cat_id" id="">
								<option value="0">Select A category</option>
							<?php
								$statement = $db->prepare("SELECT * FROM tbl_category");
								$statement->execute();
								$result = $statement->fetchAll();
								
								foreach($result as $row) {
								?>
								<option value="<?php echo $row['cat_id']; ?>"><?php echo $row['cat_name']; ?></option>
								<?php
								}
							?>
							</select>
						</td>
					</tr>
					<tr><td><b>Select a tag:</b></td></tr>
					<tr>
						<td>
					<?php
						$statement = $db->prepare("SELECT * FROM tbl_tag");
						$statement->execute();
						$result = $statement->fetchAll();
						
						foreach($result as $row) {
						?>
						<input type="checkbox" name="tag_id[]" value="<?php echo $row['tag_id']; ?>" />&nbsp; <?php echo $row['tag_name']; ?> <br />
						<?php
						}
					?>
						</td>
					</tr>
					
						
					<tr>
						<td><input type="submit" value="Publish" name="post_add" /></td>
					</tr>
				</table>
			</form>
		</div>
<?php include('footer.php'); ?>
