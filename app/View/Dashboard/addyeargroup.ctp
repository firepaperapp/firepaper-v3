<link rel="stylesheet" href="<?php echo CSS_PATH;?>fbkstyle.css" type="text/css" media="screen" title="Test Stylesheet" charset="utf-8" />
<script src="<?php echo JS_PATH;?>jquery.fcbkcomplete.min.js" type="text/javascript" charset="utf-8"></script>   
<script>
$(document).ready(function() 
{  
	//using random number to resolve cache issue
	  
 $("#otherGroups").fcbkcomplete({
            json_url: siteUrl+"dashboard/getOtherGroups/",
            cache: false, 
            filter_selected: true,
            addontab: true,                     
            height: 4,
            width:"350"          
          });		 
        
});
</script>
<?php echo $this->Form->create('classGroup', array('action'=>'','type' => 'post','id'=>'classGroup')); ?>
<div class="upload-container">
	<a href="" class="button">Add another Student</a>
	<a href="javascript:animatedcollapse.toggle('add-groups')" class="submit">Create a Year or Class group</a>
	<span class="form-title"><strong>Search:</strong> </span>
	<input class="doc-name" value="Search">
	<div class="clr"></div>
	<div style="display: block;" fade="1" id="add-groups">
			<div class="group-wrapper">	 
				<div class="group-section-first">
					<p>New group name:</p>
					 <?php echo $this->Form->input('classGroup.title',array('div'=>false,'label'=>false,"id"=>"title",'maxlength'=>'150'));?> 
				</div>
				<div class="group-section">
				<p>File under another group:</p>
				<?php echo $this->Form->input('classGroup.parentGroup',array('type'=>'select','div'=>false,'label'=>false,'options'=>$parentGroups,'id'=>"parentGroup",'empty'=>'Please Select'));?>
				</div>
				<div class="group-section-last">
					<p>Link to other groups:</p>
					<select name="data[classGroup][otherGroups]" id="otherGroups"></select>
					<div class="clr"></div>
					<a href="" class="group-tab">Maths x</a> <a href="" class="group-tab">Spanish x</a>	
				</div>
			<div class="clr"></div>                                         
	</div>
	<div class="dotted-spacer"></div>
	<div class="group-wrapper">
		<div class="group-section-last" style="padding-left: 0pt ! important;">	
			<p>Add Students:</p>
			<input name="" type="text"><a href="" class="add-btn">Add</a>
			<div class="clr"></div>
			<p>Students Added:</p>
			<a href="" class="group-tab">Sam Berrow x</a> <a href="" class="group-tab">Neil Steven x</a>
		</div>
		<div class="clr"></div>
		<a href="" class="add-btn">Submit</a>
		<div class="clr"></div>
	</div>
</div>
</div>
</form>