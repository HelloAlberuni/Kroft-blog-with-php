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
				<h3>View All Unaproved</h3>
				<table width="100%">
					<tr>
						<th width="5%">Serial</th>
						<th width="20%">Name</th>
						<th width="40%">Comment</th>
						<th width="10%">Post ID</th>
						<th width="25%">Action</th>
					</tr>
					
					<?php
					$statement = $db->prepare("SELECT * FROM tbl_comment WHERE status=?");
					$statement->execute(array(0));
					$result = $statement->fetchAll();
					
					$i = 0;
					foreach($result as $row) {
					$i++;
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $row['name']; ?></td>
						<td><?php echo $row['message']; ?></td>
						<td><a target="_blank" href="../single.php?id=<?php echo $row['post_id']; ?>"><?php echo $row['post_id']; ?></a></td>
						<td><a href="comment-aprove.php?id=<?php echo $row['id']; ?>" rel="">Aprove</a> | <a href="comment-delete.php?id=<?php $row['id']; ?>" rel="">Delete</a></td>
					</tr>
					<?php
					}
					?>
				</table>
			</div>
			<div class="table_list fix">
				<h3>View All Approved</h3>
				<table width="100%">
					<tr>
						<th width="3%">Serial</th>
						<th width="70%">Comment</th>
						<th width="30%">Action</th>
					</tr>
					
					<?php
					$statement = $db->prepare("SELECT * FROM tbl_comment WHERE status=?");
					$statement->execute(array(1));
					$result = $statement->fetchAll();
					
					$i = 0;
					foreach($result as $row) {
					$i++;
					?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo $row['message']; ?></td>
						<td><a href="comment-delete.php?id=<?php $row['id']; ?>" rel="">Delete</a></td>
					</tr>
					<?php
					}
					?>
				</table>
			</div>
		</div>
<?php include('footer.php'); ?>
