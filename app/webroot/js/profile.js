function hideTextLimit()
{
	$("#textlimit").hide();
}
$(document).ready(function (){
 		var uid= $("#userid").val(); 
		
        $("#name").editable(siteUrl+"users/updateUserName/"+uid,
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

    $("#aboutme").editable(siteUrl+"users/updateAboutMe/"+uid,
        {
            indicator :loader,
            type   : 'textarea',
            submitdata: { _method: "put" },
            select : true,
            submit : 'Ok',
            cancel : 'Cancel',
            event : 'manclick.editable',
			onsubmit: MaxTextarea,
            cols:40,
            rows : 4,
            placeholder:'',
			id : 'abtmetext',
			onreset:hideTextLimit 			 
        }
    );
	
  /*  $("#emailbox").editable("<?php echo SITE_HTTP_URL; ?>users/updateEmail",
        {
            indicator : "<img src='img/indicator.gif'>",
            type   : 'text',
            submitdata: { _method: "put" },
            callback:getData,
            select : true,
            submit : 'OK',
            cancel : 'cancel',
            event : 'manclick.editable',
            onsubmit : checkEmail
        }
    );*/

    $('#editpwdlink').click(function(){
        $("#emailbox").slideUp();
		$('#successcontainer').hide();
		$('#validation-container').empty().html('');
		$('#validation-container').hide();
		
		$('#oldpassword').val("");
		$('#password').val("");
		$('#cpassword').val("");
    	$('#pwdbox').slideDown('slow');
    });

    $('#cancelpwd').click(function(){
	    
//	   alert(document.getElementById('validation-container').style.display);
		$('#validation-container').hide();
		$('#pwdbox').slideUp();
		

    });

    $("#pwdform").validate({
    errorElement: "div",
    errorLabelContainer: "#validation-container",

    //debug:true,
    highlight: function(element, errorClass) {
   },
   unhighlight: function(element, errorClass) {
   },
   invalidHandler: function(e, validator) {
	var errors = validator.numberOfInvalids();
	if (errors) {
		$('#successcontainer').empty().hide();	
 		$("div#validation-container").show();
		//slideupdiv(2);
	} else {
		$("div#validation-container").hide();
	}
	},

   submitHandler: function(form) {

					$('#emailboxloader').empty().html(loader).show();
					$('#pwdbox').hide();
					$.post(siteUrl +'users/updatePassword/'+uid,$("#pwdform").serialize(),function(data)
                    {
                       var data_arr = data.split('@');
					   $('#emailboxloader').hide(); 
					   if($.trim(data_arr[0])=="success")
					   {
					   		$("div#validation-container").empty().hide();
							$('#successcontainer').empty().show();
							$('#successcontainer').html(data_arr[1]);
							$('#oldpassword').val("");
							$('#password').val("");
							$('#cpassword').val("");
							//slideupdiv(1);
							
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
});



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
                    $.post(siteUrl +'users/updateEmail/'+uid,$("#emailform").serialize(),function(data)
                    { 
						$('#emailboxloader').hide(); 
						var dataarr = data.split('#');
						if($.trim(dataarr[0])=="success")
						{ 
							var updtemailarr = dataarr[1].split("<br>");						
							$("#emailval").val(updtemailarr[1]) ;							
							$('#successcontainer').empty().html(dataarr[1]).show();		
							$("div#validation-container").empty().hide();
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
   rules: {
             "data[User][email]":  {required: true, email: true}


   },
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


    });

    $(function()
    {

        $("#editnamelink").click(function(){
        	
            $("#name").trigger('manclick.editable');
        }
    );
    }
);


    $(function()
    {

        $("#editabtmelink").click(function(){

            $("#aboutme").trigger('manclick.editable');
    		$("#textlimit").toggle();
        }
    );
    }
);


    function getData(data)
    {
        if($.trim(data)!=$("#emailupdt").value() && $.trim(data)!=$("#errmail").value())
        {
            $('#hiddenemail').html(data);
        }

    }

    function setName(data)
    {
        $("#name").html(data);
		if($("#userid").val()=="")
        $("#lhsuname").html(data);
    }

    function checkName()
    {
        if(document.editinplaceform.value.value=="")
        {
            alert('Please enter your name');
            return false;
        }
        else
        {
        	$("div#validation-container").empty().hide();
        }
    }

    function checkEmail()
    {
       if(document.editinplaceform.value.value=="")
        {
            alert('Please enter your email');
            return false;
        }
        else
        {
        	$("div#validation-container").empty().hide();
        }

    }
	
    $(function()
    {
        $("#editemaillink").click(function(){
			$("#email").val($("#emailval").val()) ;
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

/*	function confirmDelete(uid)
	{ 
		$('#successcontainer').hide();
		$('#validation-container').hide();
    	$("#emailbox").hide();
		$('#pwdbox').hide();
		$('#emailboxloader').empty().html(loader).show();
		
		var conf = confirm("Are you sure ,you want to delete record !")	;
		if(conf==true)
		{
			$('#emailboxloader').empty().hide();
			$.post(siteUrl+'users/deleteAccount/'+uid, '',function(){
					
					window.location= siteUrl+"dashboard/listTeachers/";
			});
			
		}
		else
		{
			$('#emailboxloader').empty().hide();
		}
	}*/



	function MaxTextarea()
	{
	
	
	//var eleId=id;
//	var remId=rId;
//	maxLen = 1500; // max number of characters allowed in the textbox
	//var el=document.getElementById('description').value;
	//alert(el);
//	alert(document.editinplaceform.value.value.length);

	var maxLen = $("#maxlimit").val();
	if(document.editinplaceform.value.value.length > maxLen)
	{
		alert("Please enter upto 1500 characters");
		//document.editinplaceform.value.value = document.editinplaceform.value.value.substring(0, maxLen);
		return false;
		
	}
	else
	{
		$("#textlimit").hide();
	}
	//if (document.getElementById(eleId).value.length > maxLen) // if too long.... trim it!
	//document.getElementById(eleId).value = document.getElementById(eleId).value.substring(0, maxLen);
	//else document.getElementById(remId).innerHTML = maxLen - document.getElementById(eleId).value.length; 

}

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
		var str = $.trim(dataarr[0]).substr(0,4); 
		if(str=='mail')
		{
			dataarr[0]= dataarr[0].substr(5);	
		}


		$("#suspend").html(dataarr[0]);
		$("#successcontainer").empty().show();
		$("#successcontainer").html(dataarr[1]);
		//slideupdiv(1);
		});
	}
}

function slideupdiv(divno)
{
	/*if(divno==1)
		setTimeout("$('#successcontainer').slideUp()",5000);

	if(divno==2)
		setTimeout("$('#validation-container').slideUp()",5000);
		*/
}






