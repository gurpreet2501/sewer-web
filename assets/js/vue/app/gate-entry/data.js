window._VUE_APP_GATE_ENRTY.data = {
	secondWeight: v('SECOND_WEIGHT'),
	canChangeSelection: true,
	entry_type:'',
	selected_form:0,
	forms:[],
	validBagsCount:true,
	validQCBagsCount:true,
	validateDate:'',
	allocation:{
		bags: 0
	},
	cmr_slip_details:{
		markets:v('cmr_markets')
	},
	common_fields: {
		account_id:0, 
		accounts:v('accounts'),
		cmr_agencies: v('cmr_agencies'), 
		truck_no:'',
		loaded_weight:0,
		tare_weight:0,
		gross_weight:0,
		packing_material_weight:0,
		deduct_packing_material:0,
		net_weight:0,
		gate_pass_no:0,
		chatni_report_no:0
	},
	
	'stock_item_types'	: [],
	'ge_godown_labor_allocation' :[],
	'bag_types'			: [],
	'quality_cut'		: [],
	'godown_material_qc_labour_allocation' : [],
	'cmr_details':{
		'account_id'	: '',
		'society_detail' : {},
		'cmr_agency_id'	: '',
		'cmr_market_id'	: '',
		'truck_no'		: '',
		'tp_no'			: '',
		'tp_date'		: '',
		'ac_note_no'	: '',
		'ac_note_date'	: '',
		'quintals'		: '',
		'no_of_bags'	: '',
		'm_serial_no'	: v('m_serial_no'),
		'cmr_agency_id'	: '',
	},
	'cmr_rice_delivery_details':{
		'ge_id'	: '',
		'cmr_agency_id'	: '',
		'delivery_to_id'	: '',
		'fci_godown_id'	: '',
		'lot_num'	: '',
	},
	
};
