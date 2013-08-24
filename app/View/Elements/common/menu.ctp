
<?php if((isset($menus))){
				foreach($menus as $output){?>
					
					<div class="left_bg left_nav"><div class="left_padding"><a href="<?php echo COMMON_URL ?>/<?php echo $output['Menu']['sLink'];?>"><?php echo $output['Menu']['sTitle']; ?></a></div>
					
			<?php }
		}
?>