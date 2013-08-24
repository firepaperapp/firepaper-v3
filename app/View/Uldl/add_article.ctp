<script type="text/javascript">
var counter;
$(document).ready(function() {
	counter = 2;
	$("#type option[value='']").attr('selected', 'selected');
	$('.article').hide();
	$('.issue').hide();
	$('#loading').hide();
	$('#minusImg').hide();
});

function onSelectChange(){
	$('.article').hide();
	$('.issue').hide();
	var id = $('#type :selected').val();
	if(id != ''){
		$("."+id).show();
	}
}

function addNextArticle(){
	length = $('#TextBoxesGroup').find('div').length+1;
	if(length >9){
            alert("Only 10 textboxes allow");
            return false;
	}
	for(i=1;i<=length;i++){
		if($("#article"+i).val() == ''){
			alert("Please fill the empty article boxes");
			return false;
		}

	}
	if(length > 1){
		$('#minusImg').show();
	}else{
		$('#minusImg').hide();
	}
	var newTextBoxDiv = $(document.createElement('div'))
	     .attr("id", 'TextBoxDiv' + counter);

	newTextBoxDiv.after().html('<span>'+counter+'.</span>&nbsp;<input type="text" id = "article'+counter+'", class="inputtext" name="article[]"  value="" onblur="return verifyArticle(this.id);">&nbsp;<span id="content'+counter+'"></span>');

	newTextBoxDiv.appendTo("#TextBoxesGroup");
	counter++;
}

function removeLastArticle(){
	length = $('#TextBoxesGroup').find('div').length;
	$('#TextBoxDiv'+length).remove();
	counter--;
	length = $('#TextBoxesGroup').find('div').length;
	if(length == 1){
		$('#minusImg').hide();
	}
}

function verifyArticle(id){

	$('#formContent').attr('disabled', true);
	$('#formContent :select').attr('disabled', true);
	$("#formContent :submit").attr("disabled", true);
	$("#"+id).attr("disabled", false);
	var articleId = $("#"+id);
	var article_no = id.replace("article", "");
	var targetUrl ='<?php echo COMMON_URL; ?>uldl/checkArticles';
	$('#plusImg').hide();

	if(articleId.val() == ''){
		alert("please fill article no. "+article_no)
		return false;
	}

	var loading = $("#loading");
	var content = $("#content"+article_no);

	//SHOW LOADING BAR
	function showLoading(){
		loading
			.css({visibility:"visible"})
			.css({opacity:"1"})
			.css({display:"block"});
		//$("#form").css({opacity:"1"})
	}
	//HIDE THE PLUS IMAGE
	function showPlus(){
		$('#plusImg').show();
		$('#formContent :input').attr('disabled', false);
		$('#formContent :select').attr('disabled', false);
		$("#formContent :submit").attr("disabled", false);
	}

	//HIDE LOADING BAR
	function hideLoading(){
		loading.hide();
		//loading.fadeTo(1000, 0);
		//$("#form").blur();
	};

	showLoading();

	//AJAX CALL
	$.ajax({
	  	url: targetUrl,
	 	success: function(data) {
	 	hideLoading();
	    $('#content'+article_no).html(data);
	    showPlus();
  		}
	});
}

function validateForm(){
	initial_sent =   $.trim($('#initial_sent').val());
	due_date =  $.trim($('#due_date').val());
	estimated_out =  $.trim($('#estimated_out').val());
	estimated_due =  $.trim($('#estimated_due').val());
	no_of_manuscript_pages =  $.trim($('#no_of_manuscript_pages').val());
	no_of_typeset_pages =  $.trim($('#no_of_typeset_pages').val());
	name = $.trim($('#name').val());
	type = $('#type :selected').val();
	manuscriptId = $.trim($('#manuscriptId').val());
	stage = $.trim($('#stage :selected').val());
	issueId = $.trim($('#issueId').val());
	description = $.trim($('#special_instruction').val());
	length = $('#TextBoxesGroup').find('div').length;
	var err = true;
	var strErr = '<ul>';
	if(name == ''){
		strErr= strErr+"<li>please fill the name.</li>";err = false;
	}
	if(type == ''){
		strErr= strErr+"<li>please Select the type.</li>";err = false;
	}
	if(type == 'article' && manuscriptId =='' ){
		strErr= strErr+"<li>please fill the manuscriptId.</li>";err = false;
	}
	if(type == 'article' && stage =='' ){
		strErr= strErr+"<li>please select the stage.</li>";err = false;
	}
	if(type == 'issue' && issueId =='' ){
		strErr= strErr+"<li>please fill the issueId.</li>";err = false;
	}
	if(type == 'issue' && length >0 ){
		for(i=1; i<=length ; i++){
			if($('#article'+i).val() == ''){
				strErr= strErr+"<li>please fill all the article id boxes.</li>";err = false;
			}
		}

	}
	if(initial_sent =='' ){
		strErr= strErr+"<li>please fill the initial sent.</li>";err = false;
	}
	if(due_date =='' ){
		strErr= strErr+"<li>please fill the due date.</li>";err = false;
	}
	if(estimated_out =='' ){
		strErr= strErr+"<li>please fill the estimated out.</li>";err = false;
	}
	if(estimated_due =='' ){
		strErr= strErr+"<li>please fill the estimated due.</li>";err = false;
	}
	if(no_of_manuscript_pages =='' ){
		strErr= strErr+"<li>please fill the issueId.</li>";err = false;
	}
	if(no_of_typeset_pages =='' ){
		strErr= strErr+"<li>please fill the issueId.</li>";err = false;
	}

	if(description == ''){
		strErr= strErr+"<li>please fill the description.</li>";err = false;
	}
	strErr= strErr+'</ul>';
	$('#formError').html(strErr);
	return err;
}
</script>
        <div class="Inner_Body_Content">
        <div id = "formContent">
        		<form id = "form" action="<?php echo COMMON_URL; ?>uldl/addArticle" name="addArticle" id="addArticle" method="post" onsubmit="return validateForm();" enctype="multipart/form-data">
          <table width="100%" border="0" cellspacing="4" cellpadding="4">
            <tr>
              <td height="6" valign="top">&nbsp;</td>
            </tr>
            <tr id="loading">
              <td  valign="top"></td>
            </tr>


            <tr>
              <td valign="top" class="Blue_Bor"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td height="10" valign="top"></td>
                </tr>
                <tr>
                  <td valign="top"><table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
		            <tr id = "formError">
		              <td height="6" valign="top"><?php if(isset($errMsg)) {echo $this->Utility->display_message($errMsg,'error',1); }?></td>
		            </tr>
                    <tr>
                      <td width="75%" valign="top"><table width="99%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td><table width="80%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                              <td height="25" colspan="2"><h1>Add Article / Issue</h1></td>
                            </tr>
                            <tr>
                              <td height="25" valign="top">*Name:</td>
                              <td>
                                <input type= "text" id="name" name = "subject" class ="inputtext" value="">
                              </td>
                            </tr>
                            <tr>
                              <td height="25" valign="top">*Select Type:</td>
                              <td><!--<label for="select"></label>
                                <select name="select" id="select" style="width:200px;">
                                </select>-->
								<select name="type" id="type" style="width:154px;" onchange="onSelectChange();" class="newListSelected" >
									<option value="" >Select Type</option>
									<option value="article" >Article</option>
									<option value="issue" >Issue</option>
								</select>
                               </td>
                            </tr>
                           <!-- <tr>
                              <td height="25">*Stage:</td>
                              <td><label for="select2"></label>
                                <select name="select2" id="select2" style="width:200px;">
                                </select></td>
                            </tr>-->

							<!--ARTICLE-->
							<tr class="article">
								<td height="25" valign="top">*Manuscript Id</td>
								<td>
								<input type= "text" id = "manuscriptId" name = "manuscript_id" class ="inputtext" value="">

								</td>
							</tr>
							<tr class="article" >
								<td height="25" valign="top" >*Stage</td>
								<td>
								<select name="stage" id="stage" style="width:154px;"  >
									<option value="" >Select Type</option>
									<?php
									foreach($Stages as $value){
										?>
										<option value="<?php echo $value['id']?>" ><?php echo $value['stage']?></option>
										<?php
									}
									?>
								</select>
								</td>
							</tr>
							<!--ARTICLE END-->

							<!--ISSUE-->
							<tr class="issue">
								<td height="25" valign="top" >*Issue Id</td>
								<td>
								<input type= "text" id = "issueId" name = "issue_Id" class ="inputtext" value="">
								<?php //echo $this->Form->input('User.stage',array('id' => 'username','label' => false,'class' => 'inputtext required','div' => '','MAXLENGTH'=>'30'));?>
								</td>
							</tr>
							<tr class="issue">
								<td height="25" valign="top" >*Article</td>
								<td valign="middle" >
								<div id = "TextBoxesGroup">
									<div id="TextBoxDiv1">
										<span>1.</span>
										<input type="text" id = "article1", class="inputtext" name="article[]"  value="" onblur="return verifyArticle(this.id);">
										<span id="content1"></span>
										<span id="plusImg" ><a href="javascript:void(0);" onclick="return addNextArticle();" ><img src="<?php echo IMAGE_PATH;?>plus.jpg" width="15px" height="15px"></a>					</span>
									</div>
								</div>
								<span id = "minusImg">
									<a href="javascript:void(0);" onclick="return removeLastArticle();"><img src="<?php echo IMAGE_PATH;?>minus.JPG" width="20px" height="6px"></a>
								</span>
								</td>
							</tr>
							<!--ISSUE END-->

                            <tr>
                              <td height="25" valign="top">*File:</td>
                              <td  height="25" valign="middle"> <!--<label for="fileField2"></label>   -->
								<input type="file" name="CatXml" id= "CatXml"><br/><br/>
							</td>
                            </tr>
                            <tr>
                              <td height="25" valign="top">*Initial sent:</td>
                              <td  height="25" >
                                <input type= "text" id="initial_sent" name = "initial_sent" class ="inputtext" value="" onclick="displayDatePicker('initial_sent','cal');"><span style="width:25px;margin-top:5px;"><a href="javascript:void(0);" onclick="displayDatePicker('initial_sent','cal');"><img src="<?php echo IMAGE_PATH; ?>calbtn.gif" id="cal" style="border:0;"/></a><b>yyyy/mm/dd</b></span>
                              </td>
                            </tr>
                                                            <tr>
                              <td height="25" valign="top">*Due Date:</td>
                              <td>
                                <input type= "text" id="due_date" name = "due_date" class ="inputtext" value="" onclick="displayDatePicker('due_date','cal1');"><span style="width:25px;margin-top:5px;"><a href="javascript:void(0);" onclick="displayDatePicker('due_date','cal1');"><img src="<?php echo IMAGE_PATH; ?>calbtn.gif" id="cal1" style="border:0;"/></a><b>yyyy/mm/dd</b></span>
                              </td>
                            </tr>
                            <tr>
                              <td height="25" valign="top">*Estimated Out:</td>
                              <td>
                                <input type= "text" id="estimated_out" name = "estimated_out" class ="inputtext" value="" onclick="displayDatePicker('estimated_out','cal2');"><span style="width:25px;margin-top:5px;"><a href="javascript:void(0);" onclick="displayDatePicker('estimated_out','cal2');"><img src="<?php echo IMAGE_PATH; ?>calbtn.gif" id="cal2" style="border:0;"/></a><b>yyyy/mm/dd</b></span>
                              </td>
                            </tr>
                                                                                    <tr>
                              <td height="25" valign="top">*Estimated Due:</td>
                              <td>
                                <input type= "text" id="estimated_due" name = "estimated_due" class ="inputtext" value="" onclick="displayDatePicker('estimated_due','cal3');"><span style="width:25px;margin-top:5px;"><a href="javascript:void(0);" onclick="displayDatePicker('estimated_due','cal3');"><img src="<?php echo IMAGE_PATH; ?>calbtn.gif" id="cal3" style="border:0;"/></a><b>yyyy/mm/dd</b></span>
                              </td>
                            </tr>
                            <tr>
                              <td height="25" valign="top">*Total number of manuscript pages:</td>
                              <td>
                                <input type= "text" id="no_of_manuscript_pages" name = "no_of_manuscript_pages" class ="inputtext" value="">
                              </td>
                            </tr>
                            <tr>
                              <td height="25" valign="top">*total number of typeset pages:</td>
                              <td>
                                <input type= "text" id="no_of_typeset_pages" name = "no_of_typeset_pages" class ="inputtext" value="">
                              </td>
                            </tr>


                            <tr>
                              <td height="25" valign="top">*Special Instruction:</td>
                              <td><label for="textarea"></label>
                                <textarea cols="40" id = "special_instruction" rows="7" name="special_instruction"></textarea>
                            </tr>
                            <tr>
                              <td height="22">&nbsp;</td>
                              <td><div class="Extn_BTN">
                                <button><span><em>Submit</em></span></button>
                                </div></td>
                            </tr>
                          </table></td>
                        </tr>
                      </table></td>
                      <td width="25%" valign="top"><table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                          <td class="Help"><h2>Help</h2>
                          		<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam blandit imperdiet elementum. Aliquam in massa sit amet risus dignissim scelerisque facilisis quis purus. Pellentesque varius dictum justo, nec bibendum ligula hendrerit id. Duis sit amet vestibulum eros. Vivamus libero felis, imperdiet ac condimentum a, elementum a risus. Mauris sed quam at ipsum consequat feugiat. Donec consequat accumsan sodales. Nam volutpat sapien massa. Proin blandit lacinia nisi, sit amet porttitor tortor pulvinar vel. Morbi commodo eros eget ipsum laoreet pellentesque. </p>
                          </td>
                        </tr>
                      </table></td>
                    </tr>
                  </table></td>
                </tr>
                <tr>
                  <td height="6" valign="top"></td>
                </tr>
              </table></td>
            </tr>
          </table>
          </form>
          </div>
  </div>






