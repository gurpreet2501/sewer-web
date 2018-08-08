jQuery(function(){
	// ?/Machine status Update Ajax
	$(".machine_status").change(function() {
     // console.log($(this).val());
     $.LoadingOverlay("show");
     var isEnabled = $(this).is(":checked");
     var machine_status = 0;
     if(isEnabled)
     		machine_status = 1; 

     var machine_id = $(this).attr('data-machine-id');
     var url = window.getBaseUrl();
	     $.ajax({
			  type: "POST",
			  url: url+'/machine/status_update',
			  data: {machine_id:machine_id,machine_status:machine_status},
			  success: function(data){

			  	data = JSON.parse(data);
			  	
			  	if(!data)
			  		alert('Unable to change machine status');
			  	$.LoadingOverlay("hide");

			  },
			});
	});


})