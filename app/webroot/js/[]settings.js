$(document).ready(function (){	
	$("#deluser").fancybox({
			ajax : {
			type	: "GET"
			}
		});

	 $("#name").editable(siteUrl+"users/updateUserName/",
        {
            indicator : loader ,
            type   : 'text',
            submitdata: { _method: "put" },
            select : true,
            submit : 'Ok',
            cancel : 'Cancel',
            event : 'manclick.editable',
            onsubmit : checkName,
            callback :setName
         }
    );
//email
	$("#emailform").validate({ 
    errorElement: "p",
    errorLabelContainer: "#validation-container",

    //debug:true,
    highlight: function(element, errorClass) {
   },
   unhighlight: function(element, errorClass) {
   },
   invalidHandler: function(e, validator) {
	var errors = validator.numberOfInvalids();
	if (errors) {
 		$("div#validation-container").show();
		//slideupdiv(2);
	} else {
		$("div#validation-container").hide();
	}
	},
   submitHandler: function(form) {   
					if($("#emailval").val()==$("#email").val())
					{ 
						return false;
					}
					$('#emailboxloader').empty().html(loader).show();
					$('#emailbox').hide(); 
                    $.post(siteUrl +'users/updateEmail/',$("#emailform").serialize(),function(data)
                    { 
						$('#emailboxloader').hide(); 
						var dataarr = data.split('#');
						if($.trim(dataarr[0])=="success")
						{ 
							var updtemailarr = dataarr[1].split("<br>");	
							//alert(updtemailarr[1]);
							$("div#validation-container").hide();
							$("#emailcontent").empty().html($("#email").val());
							$("#emailval").val($("#email").val()) ;
							$('#successcontainer').html(dataarr[1]).show();		
							//slideupdiv(1);
						}
						if($.trim(dataarr[0])=="error")
						{
							$('#successcontainer').hide();
							$('#validation-container').empty().html(dataarr[1]).show();
							//slideupdiv(2);
						}
						 
                    });

	        },

   onkeyup: false,
   rules: {  "data[User][email]":  {required: true, email: true}  },
   messages:
   {
			"data[User][email]": {
	     	required: "Please enter email address.",
	     	minLength: "Please enter valid email address."
	     }
	   }
});

$("#cancelemail").click(function(){
    $("#emailbox").slideUp();
    $("#validation-container").hide();
});

$(function()
    {
			$("#editemaillink").click(function(){
            $("#pwdbox").slideUp();
			$('#validation-container').empty().html('');
			$('#validation-container').hide();
			$('#successcontainer').hide();
            $("#emailbox").slideDown();
            $("#emailbox").trigger('manclick.editable');
            
        }
    );
    }
);
//***email ends

//username starts ankur
	$("#usernameform").validate({ 
    errorElement: "p",
    errorLabelContainer: "#validation-container",

    //debug:true,
    highlight: function(element, errorClass) {
   },
   unhighlight: function(element, errorClass) {
   },
   invalidHandler: function(e, validator) {
	var errors = validator.numberOfInvalids();
	if (errors) {
 		$("div#validation-container").show();
		//slideupdiv(2);
	} else {
		$("div#validation-container").hide();
	}
	},
   submitHandler: function(form) {    
					if($("#uniquename").val()==$("#username").val())
					{ 
						return false;
					}
					$('#emailboxloader').empty().html(loader).show();
					$('#emailbox').hide(); 
					
                    $.post(siteUrl +'users/updateUsernameUnique/',$("#usernameform").serialize(),function(data)
                    { 
						$('#emailboxloader').hide(); 
						var dataarr = data.split('@');
						if($.trim(dataarr[0])=="success")
						{ 	$("#uniquename").val(dataarr[2]) ;						
							$("#usernamediv").html(dataarr[2]) ;							
							$('#successcontainer').html(dataarr[1]).show();		
							$('#usernamebox').slideUp();
							$("div#validation-container").hide();
						}
						if($.trim(dataarr[0])=="error")
						{
							$('#successcontainer').hide();
							$('#validation-container').empty().html(dataarr[1]).show();
							
						}
						 
                    });

	        },

   onkeyup: false,
   rules: {  "data[User][username]":  {required: true}  },
   messages:
   {
			"data[User][username]": {
	     	required: "Please enter useranme.",
	     	minLength: 5
	     }
	   }
});

$("#cancelusername").click(function(){
    $("#usernamebox").slideUp();
    $("#validation-container").hide();
});

$(function()
    {
        $("#editusernamelink").click(function(){ 
            $("#pwdbox").slideUp();
			$('#validation-container').html('');
			$('#validation-container').hide();
			$('#successcontainer').hide();
            $("#usernamebox").slideDown();
            $("#usernamebox").trigger('manclick.editable');
        }
    );
    }
);
//***username ends

//**password starts here
$('#editpwdlink').click(function(){ 
        $("#emailbox").slideUp();
		$('#successcontainer').hide();
		$('#validation-container').html('');
		$('#validation-container').hide();
    	$('#pwdbox').slideDown('slow');
    });

    $('#cancelpwd').click(function(){
	    
//	   alert(document.getElementById('validation-container').style.display);
		$('#validation-container').hide();
		$('#pwdbox').slideUp();	
    });


 $("#pwdform").validate({
    errorElement: "p",
    errorLabelContainer: "#validation-container",

    //debug:true,
    highlight: function(element, errorClass) {
   },
   unhighlight: function(element, errorClass) {
   },
   invalidHandler: function(e, validator) {
	var errors = validator.numberOfInvalids();
	if (errors) {
 		$("div#validation-container").show();
		//slideupdiv(2);
	} else {
		$("div#validation-container").hide();
	}
	},

   submitHandler: function(form) {

					$('#emailboxloader').empty().html(loader).show();
					$('#pwdbox').hide();
					$.post(siteUrl +'users/updatePassword/',$("#pwdform").serialize(),function(data)
                    {
                       var data_arr = data.split('@');
					   $('#emailboxloader').hide(); 
					   if($.trim(data_arr[0])=="success")
					   {	$("div#validation-container").hide();
							$('#successcontainer').show();
							$('#successcontainer').empty().html(data_arr[1]);
							//slideupdiv(1);
								$('#oldpassword').val("");
							$('#password').val("");
							$('#cpassword').val("");	
					   }

					   if($.trim(data_arr[0])=="error")
					   { 
							$('#successcontainer').hide();
							$('#validation-container').show();
							$('#validation-container').empty().html(data_arr[1]);
							
							$('#pwdbox').show();
							//slideupdiv(2);
					   }
						
                    });

	        },

   onkeyup: false,
   rules: {
             "data[User][oldpassword]":  {required: true, minlength: 5},
			 "data[User][password]":  {required: true, minlength: 5},
			 "data[User][cpassword]":  {required: true, equalTo: "#password"}

   },
   messages:
   {
		"data[User][oldpassword]": {
	     	required: "Please enter old password.",
	     	minLength: "Old Password should be greater than 5 characters"
	     },
		
		 "data[User][password]": {
	     	required: "Please enter password.",
	     	minLength: "Password should be greater than 5 characters"
	     },
	     "data[User][cpassword]":  {
	     	required: "Please re-type password.",
	     	equalTo: "Password and Confirm Password do not match."
	     }
	   }
}); // password ends

//timezone
$("#savetimezone").click(function(){
$('#emailboxloader').empty().html(loader).show();
$.post(siteUrl +'users/updateTimezone/',{'timezone':$("#DropDownTimezone").val()}, function(data){
		$('#emailboxloader').empty().hide();
		$('#successcontainer').show();
		$('#successcontainer').empty().html(data);

	})

}); //timezone ends

//country 
$("#editcountrylink").click(function(){
$('#emailboxloader').empty().html(loader).show();
$.post(siteUrl +'users/updateCountry/',{'country':$("#DropDownCountry").val()}, function(data){
		$('#emailboxloader').empty().hide();
		$('#successcontainer').show();
		$('#successcontainer').html(data);
		$("div#validation-container").hide();
	})

}); //company ends

//company url
$("#edit_companyurl_link").click(function(){
	if($("#sitetitle").val()==$("#companyurl").val())
	{	return false ; }

$('#emailboxloader').empty().html(loader).show();
$.post(siteUrl +'users/updateSiteTitle/',{'sitetitle':$("#companyurl").val()}, function(data){
		$('#emailboxloader').empty().hide();
		var arr = data.split('@');
		if($.trim(arr[0])=="error")
		{
			$('#successcontainer').hide();
			$('#validation-container').empty().html(arr[1]).show();
		}
		if($.trim(arr[0])=="success")
		{
			$('#sitetitle').val(arr[1]);
			$('#validation-container').hide();
			$('#successcontainer').empty().html(arr[1]).show();
			
		}
	})

}); //company url ends

//logo image
$(function(){
		
        var btnUpload=$('#editimglink');
       
    
        $('#editimglink').fileUploadUI({
        	dragDropSupport: false,
	        uploadTable: $('#files1'),
	        downloadTable: $('#files1'),	        
	        buildUploadRow: function (files, index) {
	        	
	                
	             return $('<tr><td>' + files[index].name + '<\/td>' +
	                    '<td class="file_upload_progress"><div><\/div><\/td>' +
	                    '<td class="file_upload_cancel">' +
	                    '<button class="ui-state-default ui-corner-all" title="Cancel">' +
	                    '<span class="ui-icon ui-icon-cancel">Cancel<\/span>' +
	                    '<\/button><\/td><\/tr>');
	        },
	        buildDownloadRow: function (file) {
	        	 //On completion clear the status
                 
                //Add uploaded file to list 
                if("undefined" == typeof(file.success))
				{
					alert(file.error);
	
				} else{	 
						 
					$('#imgid').attr('src',siteUrl+'app/webroot/files/user_image/logo/'+file.success);
				}				        
	        },
	        beforeSend : function (event, files, index, xhr, handler, callBack) {
	        	if (files[index].size > 2097152) {
		           alert("Please upload upto 2MB only.");
		            setTimeout(function () {
                    handler.removeNode(handler.uploadRow);
               		}, 1000);
		            return;
		        }
	        	var regexp = /\.(png)|(jpg)|(gif)$/i;
	        	
	        	if (!regexp.test(files[index].name)) {
			        
			        // Using the filename extension for our test,
			        // as legacy browsers don't report the mime type
			        alert('Only JPG, PNG or GIF files are allowed!');
			        setTimeout(function () {
                    handler.removeNode(handler.uploadRow);
               		}, 1000);
			        return;
	        	}
	        	 
	        	callBack();
		    }
	    });
	    
       

	});



});//ready closed

	function setName(data)
	{
		$("#name").html(data);
		//if($("#userid").val()=="")
		$("#lhsuname").html(data);
		$('#successcontainer').empty().html("Name has been updated successfully.").show();
	}

	function checkName()
	{
		if(document.editinplaceform.value.value=="")
		{
			alert('Please enter your name');
			return false;
		} else
        {
        	$("div#validation-container").empty().hide();
        }
	}

//name
$(function(){
		$("#editnamelink").click(function(){
		$("#name").trigger('manclick.editable');
		});
	}
);

function suspendActivateAccount(uid,su_ac)
{
	
	if(su_ac=='S')
	{
		var confmsg= "suspend";
	}

	if(su_ac=='A')
	{
		var confmsg= "activate";
	}

	$('#successcontainer').hide();
	$('#validation-container').hide();
	$("#emailbox").hide();
	$('#pwdbox').hide();

	var conf = confirm("Are you sure, you want to " + confmsg + " account!");
	if(conf==true)
	{ 
	//	$("#validation-container").hide();
		$('#emailboxloader').empty().html(loader).show();
		//$("#suspend").empty().html(loader);
		$.post(siteUrl+'users/suspendActivateAccount/'+uid+'/'+su_ac,'',function(data){ 
		
		$('#emailboxloader').empty().hide();
		var dataarr = data.split("@");  
		if($.trim(dataarr[0])=="suspended")
		{
			window.location=siteUrl;
		}
		var str = $.trim(dataarr[0]).substr(0,4); 
		if(str=='mail')
		{
			dataarr[0]= dataarr[0].substr(5);	
		}


		$("#suspend").html(dataarr[0]);
		$("#successcontainer").show();
		$("#successcontainer").html(dataarr[1]);
		//slideupdiv(1);
		});
	}
}
function updatePck(pkg)
{
	if(confirm("Are you sure you want to update the package?"))
	{
		window.location = siteUrl+"users/updatePackage/"+pkg;
	}
	else
	{
		return false;
	}
}