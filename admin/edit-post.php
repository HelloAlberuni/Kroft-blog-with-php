<?php 
ob_start();
session_start();
if(!isset($_SESSION['name'])){
	header('location:login.php');
}

include('../config.php');

if(!isset($_REQUEST['id'])){
	header('location:login.php');
}
else {
	$id = $_REQUEST['id'];
}
?>

<?php

if(isset($_POST['post_add'])) {

	try{
	
		if(empty($_POST['post_title'])){
			throw new Exception('Post Title Can not be empty');
		}
	
		if(empty($_POST['post_details'])){
			throw new Exception('Post Details Can not be empty');
		}
	
		if(empty($_POST['tag_id'])){
			throw new Exception('Tag name Can not be empty');
		}
	
		if(empty($_POST['cat_id'])){
			throw new Exception('Category Can not be empty');
		}
		
		$file_name = $_FILES['new_f_image']['name'];
		$file_ext = substr($file_name,strpos($file_name,'.')+1);
		
		if(($file_ext != "png") && ($file_ext && "jpeg") && ($file_ext != "jpg")){
			throw new Exception('Image is not valid');
		}
		
		$new_name = $id.".".$file_ext;
		
		move_uploaded_file($_FILES['new_f_image']['tmp_name'],"../uploads/".$new_name);
		
		$m = 0;
		foreach($_POST['tag_id'] as $val) {
			$arrr[$m] = $val;
			$m++;
		}
		
		$tag_ids = implode(',',$arrr);
		
		$new_post_title = $_POST['post_title'];
		$new_post_details = $_POST['post_details'];
		$new_cat_id = $_POST['cat_id'];
		
		$statement = $db->prepare("UPDATE tbl_post SET post_title=?,post_details=?,featured_image=?,cat_id=?,tag_id=? WHERE post_id=$id");
		$statement->execute(array($new_post_title,$new_post_details,$new_name,$new_cat_id,$tag_ids));
		
		// $_POST['post_title'];
		// $_POST['post_details'];
		// $_POST['cat_id'];
		
		$success_message = 'Post Updated successfully';
		
	}
	catch(Exception $e){
		$err_message = $e->getMessage();
	}

}

?>

<?php

$statement = $db->prepare("SELECT * FROM tbl_post WHERE post_id=?");
$statement->execute(array($id));
$result = $statement->fetchAll();

foreach($result as $row) {
	$post_id = $row['post_id'];
	$post_title = $row['post_title'];
	$post_details = $row['post_details'];
	$featured_image = $row['featured_image'];
	$cat_id = $row['cat_id'];
	$tag_id = $row['tag_id'];
	$post_date = $row['post_date'];
	
	$post_month = substr($post_date,3,2);
	$post_year = substr($post_date,6,4);
}

?>
<?php include('header.php'); ?>
		<div class="content fix">
			<h3>Edit Post</h3>
			<?php
			
			if(isset($err_message)) {
			
				echo '<p class="error">'.$err_message.'</p>';
			
			}
			if(isset($success_message)){
				echo '<p class="success">'.$success_message.'</p>';
			}
			
			?>
			<form action="" method="post" enctype="multipart/form-data">
				<table>
					<tr><td>Post Name :</td></tr>
					<tr><td><input style="margin-bottom:5px" class="mid" type="text" name="post_title" value="<?php echo $post_title; ?>" /></td></tr>
					<tr><td>Post Description :</td></tr>
					<tr>
					<td width="500px">
						<textarea name="post_details" id="" cols="50" rows="10"><?php echo $post_details; ?></textarea>
						<script>

							// This call can be placed at any point after the
							// <textarea>, or inside a <head><script> in a
							// window.onload event handler.

							// Replace the <textarea id="editor"> with an CKEditor
							// instance, using default configurations.

							CKEDITOR.replace( 'post_details' );

						</script><p></p>
					</td>
					</tr>
					
					<tr>
					<td>
						<p><b>Previous image:</b></p>
						<img width="200";height="150" src="../uploads/<?php echo $featured_image; ?>" alt="" />
					</td>
					</tr>
					
					<tr>
					<td>
						<p><b>New Image:</b></p>
						<input value="<?php echo $featured_image; ?>" type="file" name="new_f_image" /><br /> <br />
					</td>
					</tr>
					
					<tr>
						<td><b>Select A category</b></td>
					</tr>
					<tr>
						<td>
							<select name="cat_id" id="">
								<option value="0">Select A category</option>
								<?php
									//$statement = $db->prepare("SELECT * FROM tbl_category WHERE cat_id=?");
									//$statement->execute(array($cat_id));
									$statement1 = $db->prepare("SELECT * FROM tbl_category");
									$statement1->execute();
									$result1 = $statement1->fetchAll();
									
									foreach($result1 as $row1) {
									?>
									
									<?php if($row1['cat_id'] == $cat_id): ?>
									<option selected="selected" value="<?php echo $row1['cat_id']; ?>"><?php echo $row1['cat_name']; ?></option>
									
									<?php else: ?>
									<option value="<?php echo $row1['cat_id']; ?>"><?php echo $row1['cat_name']; ?></option>
									<?php endif; ?>
									
									<?php	
									}
								?>
							</select>
						<p></p></td>
					</tr>
					<tr><td><b>Select a tag:</b></td></tr>
					<tr>
						<td>
						
							<?php
								$statement1 = $db->prepare("SELECT * FROM tbl_tag");
								$statement1->execute();
								$result1 = $statement1->fetchAll();

								foreach($result1 as $row1) {
								
									$arr2 = explode(',',$tag_id);
									$count_arr2 = count($arr2);
									$is_there = 0;
									for($j=0; $j<$count_arr2; $j++) {
									
										if($arr2[$j] == $row1['tag_id']){
											$is_there = 1;
											break;
										}
									}
									
									if($is_there == 1) {
									
										?><input type="checkbox" name="tag_id[]" value="<?php echo $row1['tag_id'] ?>" checked />&nbsp; <?php echo $row1['tag_name'] ?> <br /><?php
										
									}
									else{
									
										?><input type="checkbox" name="tag_id[]" value="<?php echo $row1['tag_id'] ?>" id="" />&nbsp; <?php echo $row1['tag_name']; ?><br /><?php
									
									}
								}
								
								
							?>
							
	
							

						</td>
					</tr>
					
						
					<tr>
						<td><input type="submit" value="Update" name="post_add" /></td>
					</tr>
				</table>
			</form>
		</div>
<?php include('footer.php'); ?>
