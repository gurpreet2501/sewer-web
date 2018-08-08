jQuery(function(){
	$(".machine_status").change(function() {
     // console.log($(this).val());
     var isEnabled = $(this).is(":checked");
     var machine_id = $(this).attr('data-machine-id');
     var url = window.getBaseUrl();
	     $.ajax({
			  type: "POST",
			  url: url+'/machine/status_update',
			  data: {machine_id:machine_id,machine_status:isEnabled},
			  success: function(data){
			  	console.log(data);
			  },
			});
	});
})