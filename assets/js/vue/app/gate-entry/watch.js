window.oldCommonFields = null;
window._VUE_APP_GATE_ENRTY.watch = {
	common_fields:{
		handler:function(newval){
			var oldVal = window.oldCommonFields;
			if(!oldVal){
				this.cmr_details.truck_no = newval.truck_no;
				this.cmr_details.account_id = newval.account_id;
				window.oldCommonFields = jQuery.extend({}, newval);
				return;
			}

			if(newval.truck_no != oldVal.truck_no)
				this.cmr_details.truck_no = newval.truck_no;

			if(newval.account_id != oldVal.account_id)
				this.cmr_details.account_id = newval.account_id;
			window.oldCommonFields = jQuery.extend({}, newval);
			return;
		},
		deep:true
	}
};
