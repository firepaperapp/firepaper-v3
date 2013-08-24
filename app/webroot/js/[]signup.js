jQuery.validator.addMethod("numberandletter", function(value, element, param) 
{
return this.optional(element) || /^[a-z0-9]+$/i.test(value);
}, "Sub-domain should contain only characters and letters.");
$(document).ready(function(){
	 
	document.testChange = 0;
	if($("#expiredate").length!=0)
	{
		//Both of thease funcations belongs to signup step2	
		$("#expiredate").datepicker({
				showOn: 'button',
				buttonImage: siteImagesUrl+'calendar.gif',
				changeMonth: true,
				changeYear: true,
				minDate: new Date(),
				buttonImageOnly: true
		});
		
	 	$("#country").change(function() {
		  var valCountry = $(this).val();
		   if( valCountry != "United States"){
		  	document.getElementById("state_dropdown").style.display = "none";
		  	document.getElementById("state_text").style.display = "inline-block";
		  	$("#vStateT").rules("add", {required: true, messages:{required:""}});
		  	$("#vStateD").rules("remove");
	
		  }
		  else{
		  	document.getElementById("state_dropdown").style.display = "inline-block";
		  	document.getElementById("state_text").style.display = "none";
		  	$("#vStateD").rules("add", {required: true, messages:{required:""}});
		  	$("#vStateT").rules("remove");
		  	
		  }
		});
			
	}
	var vh;
	$("#user").validate({
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
 		$("div#validation-container").hide();
	} else {
		$("div#validation-container").hide();
	}
	},
   onkeyup: false,
   rules: {
   		 "data[User][sitetitle]":  {required: true,numberandletter:true},	
   		 "data[User][username]":  {required: true},	
	     "data[User][email]":  {required: true, email: true},		      
	     "data[User][password]":  {required: true, minlength: 5},
	     "data[User][cpassword]":  {required: true, equalTo: "#password"},
	     "data[User][firstname]":  {required: true},
	     "data[User][lastname]":  {required: true},
	     "data[User][timezone]":  {required: true},
	     "data[User][sSecurityCode]":  {required: true},
	     "data[User][terms]":  {required: true} 
   },
   messages: 
   {
   		"data[User][terms]":{
				required: "Please accept terms and conditions.",
	       },
   		"data[User][sitetitle]":{
				required: "Please enter sub-domain name.",
	       },
	      "data[User][username]":{
				required: "Please enter username.",
	       },
	     "data[User][email]":{
				required: "Please enter email address.",
	   		email: "Please enter valid email address."
	      },
	     "data[User][password]": {
	     	required: "Please enter password.",
	     	minLength: "Password should be greater than 5 characters"
	     },
	     "data[User][cpassword]":  {
	     	required: "Please re-type password.",  	 	     	
	     	equalTo: "Password and Confirm Password do not match."
	     }
	     ,
	     "data[User][firstname]":  {
	     required: "Please enter first name."
	     },
	     "data[User][lastname]":  {
	     required: "Please enter last name."
	     },
	     "data[User][timezone]":  {
	     required: "Please enter timezone."
	     },
	     "data[User][sSecurityCode]":  {
	     required: "Please enter security code."
	     },
	     "data[User][terms]":  {
	     required: "Please accept the terms and conditions."
	     }
	   }
}); 	
$("#step2").validate({
			//errorClass:"invalid",
		   errorElement: "p",
		   errorLabelContainer: "#validation-container",
		   unhighlight: function(element, errorClass) {
	 
		   },	
		   debug:false,
		   invalidHandler: function(e, validator) {
			var errors = validator.numberOfInvalids();
			 	if (errors) {
			 		$("div#validation-container").hide();
				} else {
					$("div#validation-container").hide();
				}
			},
			submitHandler: function(form) {
	            if(document.getElementById("state_dropdown").style.display != "none"){
	            	var getState = $("#vStateD").val();
	            	$("#vState").val(getState);
	            }
	            else{
	            	var getState = $("#vStateT").val();
	            	$("#vState").val(getState);
	            }
	            form.submit();
	        },
		   onkeyup: false,
		   rules: {      
	  	     "data[User][addrsline1]":  {required: true},	 	   
	 	     "data[User][country]":  {required: true},
	 	     "data[User][city]":  {required: true},
	 	     "data[User][zipcode]":  {required: true,minlength:4, digits:true},	 	     
   	  	     "data[User][nameoncard]":  {required: true},	 	   
   	  	     "data[User][cardnumber]":  {required: true, creditcard: true},	 	   
	 	     "data[User][expiredate]":  {required: true},
	 	     "data[User][ccvcode]":  {required: true, digits:true}
	 		   },
		   messages: 
		   {
		   	 
		 	 "data[User][cardyype]":  {
			 	required: "Please choose credit card type."
			 },
	 	     "data[User][nameoncard]": {
	 	     	required: "Please enter name on card."	 	     	
	 	     },
	 	      "data[User][cardnumber]": {
	 	     	required: "Please enter card number"	 	     	
	 	     },
	 	     "data[User][expiredate]":  {
	 	     	required: "Please enter card expiry date."	 	     	
	 	     }
	 	     ,
	 	     "data[User][ccvcode]":  {
	 	     	required: "Please enter CCV code."	 	     	
	 	     }
	 	     ,
	 	      "data[User][addrsline1]":  {
			 	required: "Please enter address."
			 },
	 	     "data[User][country]":  {
	 	     required: "Please select country."	 	     
	 	     },
	 	     "data[User][city]": {
	 	     	required: "Please enter city."	 	     	
	 	     },
	 	      "data[User][zipcode]":  {
	 	     	required: "Please enter zip code" 
	 	      	
	 	     }
	 	      
 		   }
		}		
);
} 
);