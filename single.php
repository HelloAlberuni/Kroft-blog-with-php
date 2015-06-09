<?php

if(isset($_REQUEST['id'])) {
	$id = $_REQUEST['id'];
}
else {
	header('location:index.php');
}

?>

<?php include('header.php'); ?>
				
			<!-- content wrap -->	    	
	        <div id="content-wrap">
	        	
	        	<!-- Page wrap -->
	        	<div id="page-wrap">
					
					<!-- side content -->
					<div id="side-content">
					
						<?php
						
							$statement = $db->prepare("SELECT * FROM tbl_post WHERE post_id=?");
							$statement->execute(array($id));
							$result = $statement->fetchAll();
							
							foreach($result as $row) {
								$title = $row['post_title'];
								$desc = $row['post_details'];
								$date = $row['post_date'];
								$f_image = $row['featured_image'];
								$tag_id = $row['tag_id'];
							}
						
						?>
					
						<!-- single -->
						<div class="single-post">
							<div class="post">
								<div class="post-feature-img">
									<img src="uploads/<?php echo $f_image; ?>" alt="Pic" />
								</div>
								<img src="img/feature-post-shadow.png" alt="shadow" />
								
								<h4><?php echo $title; ?></h4>
								<div class="meta">
									Posted by <a href="#">admin</a>, 
									in:
									
									<?php
										
										$cat_id = $row['cat_id'];
										
										$statement3 = $db->prepare("SELECT * FROM tbl_category where cat_id=?");
										$statement3->execute(array($cat_id));
										$result3 = $statement3->fetchAll();
										
										foreach($result3 as $row3) {
											?>
											<a href=""><?php echo $row3['cat_name']; ?></a>,
											<?php
										}
										
									?>
									
									
									<b>Tags:</b>
									
									
									<?php
										$tag_ids = explode(',',$tag_id);
										$tags_count = count($tag_ids);
										
										for($j=0; $j<$tags_count; $j++) {
										
											$statement2 = $db->prepare("SELECT * FROM tbl_tag Where tag_id=?");
											$statement2->execute(array($tag_ids[$j]));
											$result2 = $statement2->fetchAll();
											
											foreach($result2 as $row2) {
												?>
												<a href=""><?php echo $row2['tag_name']; ?></a> , 
												<?php
											}
										
										}
									
									?>
								</div>
								<div class="content">
									<?php echo $desc; ?>
								</div>
								
								<?php
								
									$year = substr($date,6,4);
									$month = substr($date,3,2);
									$day = substr($date,0,2);
									
									if($month == '01'){$month = 'Jan';}
									if($month == '02'){$month = 'Feb';}
									if($month == '03'){$month = 'Mar';}
									if($month == '04'){$month = 'Apr';}
									if($month == '05'){$month = 'May';}
									if($month == '06'){$month = 'Jun';}
									if($month == '07'){$month = 'Jul';}
									if($month == '08'){$month = 'Aug';}
									if($month == '09'){$month = 'Sepp';}
									if($month == '10'){$month = 'Oct';}
									if($month == '11'){$month = 'Nov';}
									if($month == '12'){$month = 'Dec';}
								
								?>
								
								<div class="meta-date">
									<span class="meta-day"><?php echo $day; ?></span><span class="meta-month">
								<?php echo $month; ?></span><span class="meta-year"><?php echo $year; ?></span>
								</div>
								
							</div>
								
						</div>	
						<!-- ENDS single -->
											
						<?php include('comments.php'); ?>
						<!-- ENDS Comments switcher -->
						
					</div>
					<!-- ENDS side content -->
					
					<!-- sidebar -->
					<?php include('sidebar.php'); ?>
					<!-- ENDS sidebar -->
					
					<div class="clear"></div>
	        	
	        	</div>
	        	<!-- ENDS Page wrap -->
	        	
	        </div>
	        <!-- ENDS content wrap -->
	        
        </div>
		<!-- ENDS Wrapper -->
		
<?php include('footer.php'); ?>