
	 	<div class="left" id="getLatestProjects">
	 		<?php
			if($this->Session->check('Message.flash'))
			{?>
				<div class="essage errorServer">
					<div class="success">
						<?php
							$this->Session->flash(); // this line displays our flash messages
						?>
					</div>
				</div>
			<?php }
			?>
	 		<?php echo $this->requestAction("/projects/getLatestProjects/".$dept_id); ?>	
	 	 </div><!-- end left -->        
	   <div class="right">
	     		<?php echo $this->requestAction("/projects/archived");?>     
	 	</div><!-- end right -->
