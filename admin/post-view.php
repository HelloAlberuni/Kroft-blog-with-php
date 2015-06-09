<?php
ob_start();
session_start();
if(!isset($_SESSION['name'])){
	header('location:login.php');	
}
include('../config.php');
?>
<?php include('header.php'); ?>
		<div class="content fix">
			<div class="table_list fix">
				<h3>View All Posts</h3>
				<table width="100%">
					<tr>
						<th width="3%">Serial</th>
						<th width="70%">Post Name</th>
						<th width="30%">Action</th>
					</tr>
					
					<?php
					$statement = $db->prepare("SELECT * FROM tbl_post");
					$statement->execute();
					$result = $statement->fetchAll();
					
					$i = 0;
					foreach($result as $row) {
					$i++;
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $row['post_title']; ?></td>
						<td>
							<a href="#pp-<?php echo $i; ?>" rel="prettyPhoto[inline]">View </a> |
							<div id="pp-<?php echo $i; ?>" style="display:none">
								<form action="" method="post">
									<table>
										<tr><td><b>View Data: </b><br /><br /></td></tr>
										<tr><td><b>Post Title :<br /><br /></b></td></tr>
										<tr><td><?php echo $row['post_title']; ?><br /><br /></td></tr>
										<tr><td><b>Description :</b><br /><br /></td></tr>
										<tr><td><?php echo $row['post_details']; ?></td></tr>
										
										<tr><td>
										
										<?php if($row['featured_image']) : ?>
										<tr><td><b>Featured Image</b></td></tr>
										<img src="../uploads/<?php echo $row['featured_image']; ?>" alt="" />
										<?php
										else:
										endif;
										?>
										</td></tr>
										<tr><td><b>Tags:</b>
										
										<?php
										$tag_idd = explode(",",$row['tag_id']);
										$tag_ids = count($tag_idd);
										
										$k = 0;
										for($j=0; $j < $tag_ids; $j++){
											$statement2 = $db->prepare("SELECT * FROM tbl_tag where tag_id=?");
											$statement2->execute(array($tag_idd[$j]));
											$result2 = $statement2->fetchAll();
											
											foreach($result2 as $row2) {
												$arr[$j] = $row2['tag_name'];
											}
											
										}
										$k++;
										
										echo implode(" || ",$arr);
										
										?>
										
										</td></tr>
										<tr><td><b>Categories:</b>
										<?php
										$statement1 = $db->prepare("SELECT * FROM tbl_category WHERE cat_id=?");
										$statement1->execute(array($row['cat_id']));
										$result1 = $statement1->fetchAll();
										foreach($result1 as $row1) {
											echo $row1['cat_name'];
										}
										?>
										</td></tr>
									</table>
								</form>
							</div>
							<a href="edit-post.php?id=<?php echo $row['post_id']; ?>">Edit</a>| 
							<a href="post-delete.php?id=<?php echo $row['post_id']; ?>">Delete</a>
						</td>
					</tr>
					<?php
					}
					?>
				</table>
			</div>
		</div>
<?php include('footer.php'); ?>
