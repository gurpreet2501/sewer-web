//If deduct packing material checkbox is not checked then gate pass no is required else return true. i.e. not required
jQuery.validator.addMethod("deductPackMatCheck",function(value) {
	  //If checkbox not checked then required 
   if(parseInt($('#deducyP:checkbox:checked').length) == 0 && !parseInt($('input[name="gate_pass_no"]').val()))
    	return false;
    else
    	return true;

}, "Gate pass no is required!");


jQuery.validator.addMethod("gatePassValidationMaterialOut",function(value) {

    var val = $('input[name="gate_pass_no"]').val();
    console.log(val);
    // if(parseInt($('#deducyP:checkbox:checked').length) == 0 && !parseInt($('input[name="gate_pass_no"]').val()))
    if(val<=0 || !val)
    	return false;
    else
    	return true;

}, "Gate pass no is required!");
