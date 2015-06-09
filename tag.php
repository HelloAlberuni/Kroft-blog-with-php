<?php

	if(isset($_REQUEST['tag_id'])){
		$tag_id = $_REQUEST['tag_id'];
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
					
						<!-- Blog loop -->
						<div class="blog-loop">
						
						<?php
							$adjacents = 2;
														
									
							//$rrr = mysql_query("SELECT COUNT(*) as num FROM tbl_category_photo ORDER BY cat_id ASC");
							
							$statement = $db->prepare("SELECT * FROM tbl_post ORDER BY post_id DESC");
							$statement->execute();
							$total_pages = $statement->rowCount();
											
							//$total_pages = mysql_fetch_array($rrr);
							//$total_pages = $total_pages['num'];
							$targetpage = $_SERVER['PHP_SELF'];   //your file name  (the name of this file)
							$limit = 2;                                 //how many items to show per page
							$page = @$_GET['page'];
							if($page) 
								$start = ($page - 1) * $limit;          //first item to display on this page
							else
								$start = 0;
							
											
										
							//$result = mysql_query("SELECT * FROM tbl_category_photo ORDER BY cat_id ASC LIMIT $start, $limit");
							
							$statement = $db->prepare("SELECT * FROM tbl_post ORDER BY post_id DESC LIMIT $start, $limit");
							$statement->execute();
							$result = $statement->fetchAll();
							
							
							if ($page == 0) $page = 1;                  //if no page var is given, default to 1.
							$prev = $page - 1;                          //previous page is page - 1
							$next = $page + 1;                          //next page is page + 1
							$lastpage = ceil($total_pages/$limit);      //lastpage is = total pages / items per page, rounded up.
							$lpm1 = $lastpage - 1;   
							$pagination = "";
							if($lastpage > 1)
							{   
								$pagination .= "<ul class=\"pager\">";
								if ($page > 1) 
									$pagination.= "<li><a href=\"$targetpage?tag_id=$tag_id&page=$prev\">&lsaquo;</a></li>";
								else
									$pagination.= "<li class=\"disabled\"><a href=\"#\">&lsaquo;</a></li>";    
								if ($lastpage < 7 + ($adjacents * 2))   //not enough pages to bother breaking it up
								{   
									for ($counter = 1; $counter <= $lastpage; $counter++)
									{
										if ($counter == $page)
											$pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
										else
											$pagination.= "<li><a href=\"$targetpage?tag_id=$tag_id&page=$counter\">$counter</a></li>";                 
									}
								}
								elseif($lastpage > 5 + ($adjacents * 2))    //enough pages to hide some
								{
									if($page < 1 + ($adjacents * 2))        
									{
										for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
										{
											if ($counter == $page)
												$pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
											else
												$pagination.= "<li><a href=\"$targetpage?tag_id=$tag_id&page=$counter\">$counter</a></li>";                 
										}
										$pagination.= "...";
										$pagination.= "<li><a href=\"$targetpage?tag_id=$tag_id&page=$lpm1\">$lpm1</a></li>";
										$pagination.= "<li><a href=\"$targetpage?tag_id=$tag_id&page=$lastpage\">$lastpage</a></li>";       
									}
									elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
									{
										$pagination.= "<li><a href=\"$targetpage?tag_id=$tag_id&page=1\">1</a></li>";
										$pagination.= "<li><a href=\"$targetpage?tag_id=$tag_id&page=2\">2</a></li>";
										$pagination.= "...";
										for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
										{
											if ($counter == $page)
												$pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
											else
												$pagination.= "<li><a href=\"$targetpage?tag_id=$tag_id&page=$counter\">$counter</a></li>";                 
										}
										$pagination.= "...";
										$pagination.= "<li><a href=\"$targetpage?tag_id=$tag_id&page=$lpm1\">$lpm1</a></li>";
										$pagination.= "<li><a href=\"$targetpage?tag_id=$tag_id&page=$lastpage\">$lastpage</a></li>";       
									}
									else
									{
										$pagination.= "<li><a href=\"$targetpage?tag_id=$tag_id&page=1\">1</a></li>";
										$pagination.= "<li><a href=\"$targetpage?tag_id=$tag_id&page=2\">2</a></li>";
										$pagination.= "...";
										for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
										{
											if ($counter == $page)
												$pagination.= "<li class=\"active\"><a href=\"#\">$counter</a></li>";
											else
												$pagination.= "<li><a href=\"$targetpage?tag_id=$tag_id&page=$counter\">$counter</a></li>";                 
										}
									}
								}
								if ($page < $counter - 1) 
									$pagination.= "<li><a href=\"$targetpage?tag_id=$tag_id&page=$next\">&rsaquo;</a></li>";
								else
									$pagination.= "<li class=\"disabled\"><a href=\"#\">&rsaquo;</a></li>";
								$pagination.= "</ul>\n";       
							}
						?>
						
							<?php
							
								$statement = $db->prepare("SELECT * FROM tbl_post");
								$statement->execute();
								$result = $statement->fetchAll();
							
								foreach($result as $row) {
									$id_arr = explode(',',$row['tag_id']);
									foreach($id_arr as $key => $value) {
										if($value == 1) {
										?>
									<div class="post">
										<a href="single.php" class="post-feature-img">
											<img src="uploads/<?php echo $row['featured_image']; ?>" alt="Pic" />
										</a>
										<img src="img/feature-post-shadow.png" alt="shadow" />
										
										<h4><?php echo $row['post_title']; ?></h4>
										<div class="excerpt">
										
										<?php
											$word_pices = explode(' ',$row['post_details']);
											$final_words = implode(' ',array_slice($word_pices, 0, 100));
										?>
										
										<?php echo $final_words; ?>
										
										</div>
										<div class="meta">
											Posted by <a href="#">admin</a>, in 
											
											<?php
											
												$cat_id = $row['cat_id'];
												
												$statement = $db->prepare("SELECT * FROM tbl_category WHERE cat_id=?");
												$statement->execute(array($cat_id ));
												
												$result2 = $statement->fetchAll();
												foreach($result2 as $row2) {
													$cat_name = $row2['cat_name'];
												}
											
											?>
											<a href="#"><?php echo $cat_name; ?></a>,

											Tags:
											
											<?php
											
												$tag_id = $row['tag_id'];
												$tag_ids = explode(',',$tag_id);
												$count_pices =count($tag_ids);
												
												for($j=0; $j<$count_pices; $j++) {
												
													$statement3 = $db->prepare("SELECT * FROM tbl_tag WHERE tag_id=?");
													$statement3->execute(array($tag_ids[$j]));
													
													$result3 = $statement3->fetchAll();
													foreach($result3 as $row3) {
														?>
														<a href=""><?php echo $row3['tag_name']; ?></a>,
														<?php
													}
													
												}
											
											?>
											
											<a href="single.php?id=<?php echo $row['post_id']; ?>" class="read-more">Read more...</a>
										</div>
										<div style="background:#000" class="meta-date">
											<?php
												$db_value = $row['post_date'];
												$time = new Datetime($db_value);
												
												$post_date = $time->format('j');
												$post_month = $time->format('M');
												$post_year = $time->format('Y');
											?>
										
										
											<span class="meta-day"><?php echo $post_date; ?></span><span class="meta-month"><?php echo $post_month; ?></span><span class="meta-year"><?php echo $post_year; ?></span>
											
										</div>
									</div>
										<?php
										}
									}
								}
							
							?>
						
						
							<?php echo $pagination; ?>
							<div class="clear"></div>
							<!-- ENDS pager -->
				
				
						</div>
						<!-- ENDS Blog loop -->
						
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