<div class="clr"></div>
<?php       
if($totalPages>1)
{?>
<div id="pagination" class="pagination"> 
	  <?php 
  	 	if($page>1)
	  		echo '<span>'.$this->Paginator->prev().'</span>';
	  ?> 
	  <?php
      echo $this->Paginator->numbers(array('separator'=>'')); 
      ?>
      <?php       
	 	if($page < $totalPages)
	  		echo '<span>'.$this->Paginator->next().'</span>';
	  ?>       
<!-- prints X of Y, where X is current page and Y is number of pages -->
</div>
<?php } 
else { ?>
<div id="pagination" class="pagination">&nbsp;</div>
<?php }?>
</div>