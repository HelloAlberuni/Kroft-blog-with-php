<?php
if(isset($_POST['contact'])) {
	try{
		if(empty($_POST['name'])) {
			throw new Exception('You must enter your name');
		}
		if(empty($_POST['email'])) {
			throw new Exception('You must enter your email');
		}
		if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			throw new Exception('Invalid email format! Please enter a valid email address');
		}
		if(empty($_POST['comments'])) {
			throw new Exception('Please write down your message');
		}
		
		
		$name=$_POST['name'];
		$email=$_POST['email'];
		$comments=$_POST['comments'];
		$to="md.azad1216@gmail.com";
		$message="Name: $name \n\n Email: $email \n\n Message: $comments";
		
		if(mail($to,"Contact From my Kroft Blog", $message, "FROM: $email")){
			$success_message = "Form data sent. Thanks for your comments.";
		}
		else{
			throw new Exception('Sorry, your messege hasnt been sent');
		}
	}
	catch(Exception $e) {
		$err_message = $e->getMessage();
	}
}
?>

<?php include('header.php'); ?>

<style type="text/css">
	.error{color:red;font-weight:bold;}
	.success{color:green;font-weight:bold;}
</style>
				
			<!-- content wrap -->	    	
	        <div id="content-wrap">
	        	
	        	<!-- Page wrap -->
	        	<div id="page-wrap">
	        	
					<div class="page-title"><h1>Contact</h1> <span>Where and how to get in touch</span></div>
					
					<!-- side content -->
					<div id="side-content">

						<h4>Lorem ipsum dolor</h4>
						
						<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vi sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum.</p>
							<p>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet est et sapien ullamcorper pharetra. Vestibulum erat wisi, condimentum sed, commodo vitae, ornare sit amet, wisi. Aenean fermentum.</p>
						
					
						
						<h2 class="title-divider">Contact form</h2>		

						<?php
							if(isset($err_message)){
								echo '<p class="error">'.$err_message.'</p>';
							}
							if(isset($success_message)){
								echo '<p class="success">'.$success_message.'</p>';
							}
						?>
						
						<!-- form -->

						<form id="contactForm" action="" method="post">
							<fieldset>
								<div>
									<input name="name"  id="name" type="text" class="" title="Enter your full name" />
									<label>Name</label>
								</div>
								<div>
									<input name="email"  id="email" type="text" class="" title="Enter your email address" />
									<label>Email</label>
								</div>
								<div>
									
									<input name="web"  id="web" type="text" class="" title="Enter your website" />
									<label>Website</label>
								</div>
								<div>
									<textarea  name="comments"  id="comments" rows="5" cols="20" class="" title="Enter your comments"></textarea>
								</div>
								
								<p><input type="submit" value="Send" name="contact" id="submit" /> </p>
							</fieldset>
							
						</form>
						<p id="success" class="success"></p>
						<!-- ENDS form -->
				
									
						
					</div>
					<!-- ENDS side content -->



						
															
					
					<!-- sidebar -->
					<div id="sidebar">
						<h4>Location map</h4>
						<!-- Google map -->
						
						<!-- GOOGLE MAPS -->
						<script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAAyXu_1Zw3-DbyonSxgLICyxSWQUvSd76__Y3fi9Kog3e7ZrY_3BSXzMhasJq2gZLNOWT1yWR8ut-FDA" ></script>
						<script type="text/javascript" >google.load("maps","2.x");</script>
						
						<script type="text/javascript">
							
							jQuery(document).ready(function($) {
							
							//##########################################
							// Google maps
							//##########################################
							
							// You can get the latitud and Longitude values at http://itouchmap.com/latlong.html
							
							var latitude = 44.8011821;
							var longitude = -68.7778138;
							
							// center map
							var map = new GMap2(document.getElementById("map")); 
							var point = new GLatLng(latitude, longitude); 
							map.setCenter(point, 16);
							
							// Set marker
							marker = new GMarker(point); 
							map.addOverlay(marker);
							
							// controls
							map.addControl(new GLargeMapControl());
							
							});
						</script>
						<!-- ENDS GOOGLE MAPS -->
		
		
						<div id="map"></div>
						<!-- ENDS Google map -->
	
						
						
					</div>
					<!-- ENDS sidebar -->
					
					<div class="clear"></div>
	        	
	        	</div>
	        	<!-- ENDS Page wrap -->
	        	
	        </div>
	        <!-- ENDS content wrap -->
	        
        </div>
		<!-- ENDS Wrapper -->
		
<?php include('footer.php'); ?>