<?php

$post_id = $_REQUEST['id'];
if(isset($_POST['submit'])) {
	$post_id = $_REQUEST['id'];
	$name = $_POST['author'];
	$email = $_POST['email'];
	$website = $_POST['url'];
	$message = $_POST['comment'];
	$status = 0;


	try {
		if(empty($name)) {
			throw new Exception('You must need to enter your Name');
		}
		if(empty($email)) {
			throw new Exception('You must need to enter your Email');
		}
		if(empty($message)) {
			throw new Exception('You must need to enter your Comment');
		}
		
		$statement = $db->prepare("INSERT INTO tbl_comment (post_id,name,email,website,message,status) VALUES (?,?,?,?,?,?)");
		$statement->execute(array($post_id,$name,$email,$website,$message,$status));
		
		$success_message = "Your comments is under approval it will be publish ASAP";
		
		
	}
	catch(Exception $e){
		$err_message = $e->getMessage();
	}	

}

?>

<style type="text/css">
	.error{color:red;font-weight:bold}
	.success{color:green;font-weight:bold}
</style>

<?php

	if(isset($err_message)) {
		echo '<p class="error">'.$err_message.'</p>';
	}
	if(isset($success_message)){
		echo '<p class="success">'.$success_message.'</p>';
	}

?>

					<?php
					
						$statement = $db->prepare("SELECT * FROM tbl_comment WHERE post_id=? AND status=1");
						$statement->execute(array($post_id));
						
						$result = $statement->fetchAll();
						if(count($result) <= 1){ $cmnt = "comment";}
						if(count($result) > 1){ $cmnt = "comments";}
					?>
											
						<!-- Comments switcher -->
						<h6 class="show-comments"><?php echo count($result)." "; echo $cmnt; ?> <span>click to show</span></h6>
						
						<div class="comments-switcher">
						
							<!-- comments list -->
							<div id="comments-wrap">
								<ol class="commentlist">
								
								

								<?php foreach($result as $row){ ?>
								
								
									<li class="comment even thread-even depth-1" id="li-comment-3">
										
										<div id="comment-3" class="comment-body clearfix">
											
											<?php
												$email = $row['email'];
												$default = "http://0.gravatar.com/avatar/4f64c9f81bb0d4ee969aaf7b4a5a6f40?s=35&amp;d=&amp;r=G";
												$size = 40;
												
												$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $email ) ) ) . "?d=" . urlencode( $default ) . "&s=" . $size;

											?>
											
									     	<img alt='' src='<?php echo $grav_url; ?>' class='avatar avatar-35 photo' height='35' width='35' />
											
									     	<div class="comment-author vcard"><?php echo $row['name']; ?></div>
									        <div class="comment-meta commentmetadata">
												<span class="comment-reply-link-wrap"></span>
											</div>
									  		<div class="comment-inner">
										   		<p><?php echo $row['message']; ?></p>
									 		</div>
								     	</div>
									</li>
									
								<?php	}
								
								?>
									
								</ol>
							</div>
							<!-- ENDS comments list -->
		
		
							<!-- Respond -->				
							<div id="respond">
								<h6 class="s-title">Leave a Comment</h6>
								<div class="cancel-comment-reply"><a rel="nofollow" id="cancel-comment-reply-link" href="#respond" style="display:none;">Cancel reply</a></div>
								<form action="" method="post" id="commentform">
									<input type="text" name="author" id="author" value="" tabindex="1" />
									<label for="author">Name <small>*</small></label><br/>
								
									<input type="text" name="email" id="email" value="" tabindex="2" />
									<label for="email">Email <small>*</small> <span>(not published)</span></label><br/>
								
									<input type="text" name="url" id="url" value="" tabindex="3" />
									<label for="url">Website</label>
								
									<textarea name="comment" id="comment"  tabindex="4"></textarea>
										
									<p><input name="submit" type="submit" id="submit" tabindex="5" /></p>	
								</form>
							</div>
							<div class="clear"></div>
							<!-- ENDS Respond -->
						</div>