jQuery.validator.addMethod("qcValidate", function(value) {

	valid=true;
	
  var selectBoxes = $('.quality_cut_dd');
  var errors = [];


  //Checking 
  $.each(selectBoxes, function() {
  	var parentTr = $(this).closest('tr');	
		if(!$(this).find(":selected").text().length && parentTr.find('.qc_total').text() <= 0)
 		  errors.push(true);
	 else if($(this).find(":selected").text().length && parentTr.find('.qc_total').text() <= 0)
		 	errors.push(false);
		 else if($(this).find(":selected").text().length && parentTr.find('.qc_total').text() > 0){
		 	errors.push(true);
		 }

	});
	$.each(errors, function(key,val) {	
		if(val == false)
			valid = false;
	});

	return valid;
   
}, "Please complete the quality cut entry!");

