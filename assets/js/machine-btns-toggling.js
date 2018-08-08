jQuery(function(){
	// ?/Machine status Update Ajax
	$(".machine_status").change(function() {
     // console.log($(this).val());
     $.LoadingOverlay("show");
     var isEnabled = $(this).is(":checked");
     var machine_status = 0;
     if(isEnabled)
     		machine_status = 1; 

     var machine_serial = $(this).attr('data-machine-serial');
     var url = window.getBaseUrl();
	     $.ajax({
			  type: "POST",
			  url: url+'/machine/status_update',
			  data: {machine_serial:machine_serial,machine_status:machine_status},
			  success: function(data){

			  	data = JSON.parse(data);
			  	
			  	if(!data)
			  		alert('Unable to change machine status');
			  	$.LoadingOverlay("hide");

			  },
			});
	});

// Button status code
	$(".button_status").change(function() {
     // console.log($(this).val());
     $.LoadingOverlay("show");
     var isEnabled = $(this).is(":checked");
     var button_status = 0;
     if(isEnabled)
     		button_status = 1; 

     var machine_serial = $(this).attr('data-machine-serial');
     var url = window.getBaseUrl();
	     $.ajax({
			  type: "POST",
			  url: url+'/machine/button_status_update',
			  data: {machine_serial:machine_serial,button_status:button_status},
			  success: function(data){

			  	data = JSON.parse(data);
			  	
			  	if(!data)
			  		alert('Unable to change button status');
			  	$.LoadingOverlay("hide");

			  },
			});
	});


//Machine block code
	$(".machine_blocked_status").change(function() {
     // console.log($(this).val());
     $.LoadingOverlay("show");
     var isEnabled = $(this).is(":checked");
     var machine_blocked_status = 0;
     if(isEnabled)
     		machine_blocked_status = 1; 

     var machine_serial = $(this).attr('data-machine-serial');
     var url = window.getBaseUrl();
	     $.ajax({
			  type: "POST",
			  url: url+'/machine/block',
			  data: {machine_serial:machine_serial,machine_blocked_status:machine_blocked_status},
			  success: function(data){
			  	data = JSON.parse(data);
			  	if(!data)
			  		alert('Unable to change button status');
			  	$.LoadingOverlay("hide");

			  },
			});
	});


})