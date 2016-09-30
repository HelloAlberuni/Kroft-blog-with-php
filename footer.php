		<!-- FOOTER -->
		<div id="footer">
			<div class="footer-wrapper">
				
				
				<!-- footer-cols -->

				<!-- ENDS footer-cols -->
				
				<div id="footer-glare"></div>
				
			</div>
		</div>
		<!-- ENDS FOOTER -->
		

		<div id="footer-bottom">
			<div class="bottom-wrapper"> 
				<center><p style="color:#fff">
				<?php
					
					$statement = $db->prepare("SELECT * FROM tbl_footer_text WHERE id=?");
					$statement->execute(array(3));
					
					$result = $statement->fetchAll();
					foreach($result as $row){
						echo $row['footer_text'];
					}
					
				?>
				</p></center>
			</div>
		</div>
		
	</body>
</html>
