 window.__ADD_LABOR_JOB__ = new Vue({
	el: '#add-new-labor-job',
	data: {
		accounts:v('accounts'),
		laborJobTypes:v('laborJobTypes'),
		account_id:0,
		godowns:v('godowns'),
		labour_job_type_id:0,
		job_labour_cat_id:0,
		labour_rate:0,
		bags:0,
		godown_id:0
	},
	computed: {

	},
	methods: {

		filterLaborJobTypes:function(){
			var laborPartyJobTypes = [];
			var job_labour_cat_id = this.job_labour_cat_id;
			$.each(this.laborJobTypes, function( index, values ) {
				
				if(values.labour_job_category_id == job_labour_cat_id){
		  		 laborPartyJobTypes.push(values);
		  		}    
			});

		  return laborPartyJobTypes;
		},

		getLabourTypeRate:function(){

				var account_id = this.account_id;
				var labour_job_type_id = this.labour_job_type_id;
			  var rate = 0.0;		
				$.each(this.accounts, function(index, values) {
				  $.each(values.labor_party_job_types, function(index, values) {
				  		if(values.labour_job_type_id == labour_job_type_id && values.account_id == account_id)
				  				rate = values.rate;
				  });	
										
			  });	
 				
 				this.labour_rate = rate;

		},

		filterAccountLaborJobCategories:function(){
			var accountLabJobCat = [];
			var account_id = this.account_id;
			$.each(this.accounts, function( index, values ) {
				if(values.id == account_id){
		  		 accountLabJobCat = values.accountlabour_job_categories;
		  		}    
			});
		  return accountLabJobCat;
		},

		calculateJobTotal:function(){

				     var total = numeral(this.bags*this.labour_rate);
					   var amount = total.format('0,0.00');
			return amount;
		},

		findJobCatIdFromLaborJobTypeId:function(lab_job_type_id){
      var labour_job_cat_id = 0;
			$.each(this.laborJobTypes, function( index, values ) {
				if(values.id == lab_job_type_id){
		  		   labour_job_cat_id = values.labour_job_category_id;
		  		}    
			});
			this.labour_job_type_id = lab_job_type_id;
			this.job_labour_cat_id = labour_job_cat_id;

		}

	}
});
 console.log(v('qc_allocation_entry'));

 window.__ADD_LABOR_JOB__.account_id = v('qc_allocation_entry').labour_party_id;
 var lab_job_type_id = v('qc_allocation_entry').labour_job_type_id; 
 window.__ADD_LABOR_JOB__.findJobCatIdFromLaborJobTypeId(lab_job_type_id);
 window.__ADD_LABOR_JOB__.getLabourTypeRate();
 window.__ADD_LABOR_JOB__.bags = v('qc_allocation_entry').bags;
 window.__ADD_LABOR_JOB__.godown_id = v('qc_allocation_entry').godown_id;
 