<script type="text/javascript">
$(document).ready(function() {
	var randomnumber=Math.floor(Math.random()*101);
	loadPiece(siteUrl+"dashboard/listActivity/?rand="+randomnumber,"#dropbox_activity");
	//Default Action
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content
	
	//On Click Event
	$("ul.tabs li").click(function() {
		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
		if(activeTab == "#tab1")
		{
			// We will make a ajax call to get the elemnts
			loadPiece(siteUrl+"files/listFiles/?rand="+randomnumber,"#dropbox_files");
		}
		if(activeTab == "#tab2")
		{	 
			// We will make a ajax call to get the elemnts
			loadPiece(siteUrl+"dashboard/listActivity/?rand="+randomnumber,"#dropbox_activity");
		}
		
		if(activeTab == "#tab3")
		{
			// We will make a ajax call to get the elemnts
			loadPiece(siteUrl+"projects/listProjectsDropbox/?rand="+randomnumber,"#dropbox_projects");
		}
		$(activeTab).fadeIn(); //Fade in the active content
		return false;
	});
	
	});
</script>
<div class="col2 widget" style="display:none;">

<ul class="tabs">
 	<?php  	
	$url = isset($_SERVER['REQUEST_URI'])?$_SERVER['REQUEST_URI']:"";
	?>	
	<li id="files"><a href="#tab2"></a></li>
	<?php if(false !==  strpos($url , 'files/getFiles')) {?>
	<li id="projects"><a href="#tab3"></a></li>
	<?php }elseif(false !==  strpos($url , 'projects/viewDetails') || false !==  strpos($url , 'projects/addEditProject')) {?>
	<li id="files"><a href="#tab1"></a></li>
	 <?php } ?>
  </ul>
  <div class="clr"></div>
  
  <div class="tab_container">
    <div style="display: block;" id="tab2" class="tab_content">
      	
    <div id="dropbox_activity">
	   <div class="clr"></div>
	   </div>
   </div>

  <div style="display: none;" id="tab1" class="tab_content">
    <div class="side-container">
	      <div class="tip-box">
	        <p><span>Tip:</span> You can drag and drop your files </p>
	      </div>
     	 <div id="dropbox_files"  style="float:left;width:100%;">
         
	      </div> <div class="clr"></div>
      </div>
  </div>
  <div style="display: none;" id="tab3" class="tab_content">
    <div class="side-container">
      <div class="tip-box">
        <p><span>Tip:</span> You can drag files into projects </p>
      </div>
       <div  id="dropbox_projects">
       </div>
      <div class="clr"></div>
    </div>
  </div>
    </div>
  <div class="clr"></div>
</div>
