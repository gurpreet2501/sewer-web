jQuery.validator.addMethod("tpDateValidate",function(value) {
  
  if(parseInt(value.replace(/-/g,'')) > 0)
		 return true;
	return false;	
   
}, "Please enter a valid date!");

