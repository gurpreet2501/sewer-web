jQuery(function(){
	$('.cancel-ge-btn').click(function(e){
		var entry = this;
		var user_id = $(this).attr('data-user_id');
		var ge_id = $(this).attr('data-ge_id');

		e.preventDefault();

		swal("Enter Cancellation Reason:", {
	    content: {
		    element: "input",
		    attributes: {
		      placeholder: "Reason for cancelation (Required)",
		      type: "textarea",
		      rows:5
		    },
		  },
	    icon: "warning",
	    html: true,
	    buttons: {
		    confirm: true,
		    cancel: true,
		    confirm: "Cancel Entry",
		    cancel: 'Close',
		  },
	  })
	  .then((value) => {
	    if(value == false || value == null){
	    	return false;
	    }
	    
	    var params = encodeURI("reason="+value+"&user_id="+user_id+"&ge_id="+ge_id);
	 
     location.href= getBaseUrl()+"/gate_entry/cancel/?"+params;

	  })

	});

});
