jQuery(function(){
	var obj = window.GATE_ENTRY
	var gateEntry = window.for_js.gate_entry;
	if(gateEntry == null)  
	 	return;
	obj.canChangeSelection = false; 

	obj.selectEntryType(gateEntry.entry_type);
  	obj.selectForm(gateEntry.form_id);
	var fields = ['tare_weight','account_id','truck_no','loaded_weight','deduct_packing_material',
	 							'packing_material_weight','chatni_report_no','gate_pass_no'
 	 ];
 
	 $.each(fields, function(key, fieldValue){
   		 obj.common_fields[fieldValue] = gateEntry[fieldValue];
	 }); 

	 //Assigning Values to modules
	 obj.godown_material_qc_labour_allocation = gateEntry.godown_qc_labor_allocation
   
   obj.ge_godown_labor_allocation = [];	 
	 obj.ge_godown_labor_allocation = gateEntry.godown_labor_allocation

	 obj.quality_cut = [];
	 obj.quality_cut = gateEntry.quality_cuts;

	 
	 obj.godown_labor_allocation = [];
	 obj.ge_godown_labor_allocation = gateEntry.godown_labor_allocation[0];

	 obj.cmr_details = [];
	 obj.cmr_details = gateEntry.cmr_details[0];

	 obj.cmr_rice_delivery_details = [];
	 obj.cmr_rice_delivery_details = gateEntry.cmr_rice_delivery_details[0];

	
	 // console.log(obj.stock_item_types);
	 if(gateEntry.stock_items.length){
		 $.each(obj.stock_item_types , function(index, emptyStockItem){

		 		$.each(gateEntry.stock_items, function(geIndex, geItem){
		 			if(emptyStockItem.stock_item.id == geItem.stock_item.id)
						emptyStockItem.bags = geItem.bags;
		 		});
		 });
	 }

	 // if(gateEntry.stock_items.length){	 	
		//  obj.stock_item_types = [];
		//  $.each(gateEntry.stock_items, function(key, value){
		//  	 obj.stock_item_types.push(obj.hashed(value));
		//  })
	 // }

	$.each(obj.bag_types, function(key, value){
		var item  = Store.query(gateEntry.bag_types)
			  		 .where('stock_item_id',value.stock_item.id)
			  		 .first();
		if(item)
			obj.bag_types[key].bags = item.bags;
	});


  

});
