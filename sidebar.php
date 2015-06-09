					<div id="sidebar">
						<div class="sideblock">
							<h6 class="side-title">Categories</h6>
							<ul class="cat-list">
								
								<?php
									
									$statement = $db->prepare("SELECT * FROM tbl_category");
									$statement->execute();
									
									$result = $statement->fetchAll();
									foreach($result as $row) {
										?>
										<li><a href="category.php?cat_id=<?php echo $row['cat_id']; ?>" > <?php echo $row['cat_name']; ?> </a></li>
										<?php
									}
									
								?>
								
								
					    	</ul>
				    	</div>
						<div class="sideblock">
							<h6 class="side-title">Archives</h6>
							<ul class="cat-list">
								
								<?php
									
									$statement = $db->prepare("SELECT DISTINCT(post_date) FROM tbl_post");
									$statement->execute();
									
									$result = $statement->fetchAll();
									
									$j = 0;
									foreach($result as $row) {
										$ym = substr($row['post_date'],3,7);
										$arr_date[$j] = $ym;
										$j++;
									}
									$unique_arr = array_unique($arr_date);
									$arr_imp = implode(',',$unique_arr );
									$arr_exp = explode(',',$arr_imp);
									$count = count($arr_exp);
									
									for($j = 0; $j < $count; $j++) {
										$year = substr($arr_exp[$j],3,4);
										$month = substr($arr_exp[$j],0,2);
										
										if($month == "01") {$month_full = "January";}
										if($month == "02") {$month_full = "February";}
										if($month == "03") {$month_full = "March";}
										if($month == "04") {$month_full = "April";}
										if($month == "05") {$month_full = "June";}
										if($month == "06") {$month_full = "july";}
										if($month == "07") {$month_full = "August";}
										if($month == "08") {$month_full = "September";}
										if($month == "09") {$month_full = "October";}
										if($month == "11") {$month_full = "November";}
										if($month == "12") {$month_full = "December";}
										
										?>
											<li><a href="archive.php?date=<?php echo $month.'-'.$year; ?>"><?php echo $month_full.' - '.$year; ?></a></li>
										<?php
									}
									
								?>
								
					    	</ul>
				    	</div>
				    	
				    	<div class="sideblock">
							<h6 class="side-title">Post tags</h6>
							<ul class="wp-tag-cloud">
								<?php
								
									$statement = $db->prepare("SELECT * FROM tbl_tag");
									$statement->execute();
									
									$result = $statement->fetchAll();
									foreach($result as $row) {
										?>
										<li><a href="tag.php?tag_id=<?php echo $row['tag_id']; ?>"><?php echo $row['tag_name']; ?></a></li>
										<?php
									}
								
								?>
							</ul>
				    	</div>
				    	
					</div>