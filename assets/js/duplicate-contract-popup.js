function duplicateContractPopUp(){

	return swal({
	  title: 'Duplicate Contract Exists',
	  type: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  focusConfirm:false,
	  cancelButtonColor: '#d33',
	  confirmButtonText: 'Edit'
	}).then((result) => {
		console.log(result);
	  if (result.value) {
	     location.href = getBaseUrl()+'/manager_dashboard/edit_rate_contract/'+v('duplicateContractId');
	  }
	});

	
}