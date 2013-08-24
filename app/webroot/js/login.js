$(document).ready(function(){
  	 	var vh;
		$("#login").validate({
		  errorElement: "p",
    	  errorLabelContainer: "#validation-container",		 
		  onkeyup: false,
          invalidHandler: function(e, validator) {
			var errors = validator.numberOfInvalids();
			 	if (errors) {
			 		$("div#validation-container").hide();
				} else {
					$("div#validation-container").hide();
				}
			},
		   rules: {	 	           
	 	     "data[username]":  {required: true},
	 	     "data[password]":  {required: true,minlength:5}
  		   },
		   messages: 
		   {
		     "data[username]":{
	 			required: "Please enter username or email address.",
	 		  		
		      },
			
	 	     "data[password]":  {
	 	     required: "Please enter password.",
	 	     minlength: "Password should be greater than 5 characters."
	 	     } 
 		   }
		});   
		$("#forgotpassword").validate({
		  errorElement: "p",
    	  errorLabelContainer: "#validation-container",		 
		  onkeyup: false,
          invalidHandler: function(e, validator) {
			var errors = validator.numberOfInvalids();
			 	if (errors) {
			 		$("div#validation-container").hide();
				} else {
					$("div#validation-container").hide();
				}
			},
		   rules: {	 	           
	 	     "data[email]":  {required: true, email:true}	 	     
  		   },
		   messages: 
		   {
		     "data[email]":{
	 			required: "Please enter email address.",
	 			email: "Please enter valid email address.",
	 		  		
		      } 
 		   }
		});   
    });	