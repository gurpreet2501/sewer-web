 var cmr = new Vue({
	el: '#cmr-details',
	data: {
		account_id:v('stub').account_id,
		cmr_market_id:v('stub').cmr_market_id,
		ac_note_no:v('stub').ac_note_no,
		quintals:v('stub').quintals,
		m_serial_no:v('stub').m_serial_no,
		truck_no:v('stub').truck_no,
		tp_no:v('stub').tp_no,
		tp_date:v('stub').tp_date,
		ac_note_date:v('stub').ac_note_date,
		cmr_agency_id:v('stub').cmr_agency_id,
		no_of_bags:v('stub').no_of_bags,
		accounts:v('accounts'),
		cmr_agencies:v('cmr_agencies'),
		cmr_societies:v('cmr_societies'),
		truck_no:v('stub').truck_no,
		markets:v('markets'),
	},
	computed: {

	},
	methods: {
	
  upper() {
       	this.truck_no = this.truck_no.toUpperCase();
  },
	getSocietyDetail:function(){
		// console.log(marketId);
		 var marketId = this.cmr_market_id;
		 var society = [];
		 var market = '';
		
		 $.each(v('markets'), function(key, val){
		 	if(marketId == val.id)
		 		market  = val;
		 });
		 // cmrSocietyId = market[0].cmr_society_id;

		 $.each(v('cmr_societies'), function(key, val){
		 	if(market.cmr_society_id == val.id)
		 		society.push(val);
		 });
		 return society;
		
	}


	}
});
