window._VUE_APP_GATE_ENRTY.methods = {
	selectEntryType:function(type){
		this.entry_type = type;

		this.forms = Store.query('forms')
					.where('type', type).get();
	},

	selectForm:function(form_id){

		this.selected_form = form_id;
		this.buildStockItemTypes();
		this.buildBagtypes();
		this.quality_cut = [];
		this.addQCCut();
		this.godown_material_qc_labour_allocation = [];
		this.addGodownAllocation();
	},

	getSocietyDetail:function(){
		// console.log(marketId);
		 var marketId = this.cmr_details.cmr_market_id;
		 var society = [];
		 var market = '';
		
		 $.each(v('cmr_markets'), function(key, val){
		 	if(marketId == val.id)
		 		market  = val;
		 });
		 // cmrSocietyId = market[0].cmr_society_id;

		 $.each(v('cmr_societies'), function(key, val){
		 	if(market.cmr_society_id == val.id)
		 		society.push(val);
		 });

		 return society;
		
	},
  
  upper() {
       	this.common_fields.truck_no = this.common_fields.truck_no.toUpperCase();
  },

	addQCCut: function(){
		var self =  this;
		this.quality_cut.push(self.hashed({
			'quality_cut_type' 	: '',
			'bags'			 	: '',
			'qty_per_bag'		: '',
			'remarks'			: ''
		}));
	},

	addGodownAllocation: function(){
		var self =  this;
		setTimeout(function(){self.godown_material_qc_labour_allocation.push(self.hashed({
				'stock_item_id' 		: '',
				'bags'			 		: '',
				'godown_id'				: '',
				'labour_party_id'		: '',
				'labour_job_type_id'	: '',
				'remarks'				: ''
		}));  }, 100);
		

	},

	removeGodownAllocation: function(qc){
		var ind = this.godown_material_qc_labour_allocation.indexOf(qc);
		if(ind  === -1)
			return;
		this.godown_material_qc_labour_allocation.splice(ind,1);
	},

	removeQCCut: function(qc){
		var ind = this.quality_cut.indexOf(qc);
		if(ind  === -1)
			return;
		this.quality_cut.splice(ind,1);
	},

	selectQualityCutTotal:function(qc){
		var total = parseFloat(qc.bags)*parseFloat(qc.qty_per_bag);

		return this.NaNsafe(total.toFixed(2));
	},

	NaNsafe:function(val){
		return isNaN(val)? 0 :val;
	},

	buildBagtypes:function(){
		var self =  this;
		var module = this.getModuleConfig('bag_types');
		var builtCollection = [];
		if(module==null)
			return;
		$.each(module.stock_items, function(){
			builtCollection.push(self.hashed({
				'bags'			: '',
				'stock_item'	: this,
			}));
		});

		this.bag_types = builtCollection;			
	},

	checkGatePassDuplicacy:function(){
		$('.gate-pass-duplicate.custom-error-msg').show();
		var ajaxUrl = getBaseUrl()+'/gate_pass/checkGatePassDuplicacy';
		var exists = true;
		var gatePassNo = $('#gate_pass_no_check').val();
	  var self = this;			
		$.ajax({
		  method: "POST",
		  url: ajaxUrl,
		  data: { gate_pass_no: gatePassNo }
		})
		  .done(function(data) {
		    var result = JSON.parse(data);
		    if(result == 1){
		    	$('.gate-pass-duplicate.custom-error-msg').show();
		    	return false;
		    }
		    else{
		    	$('.gate-pass-duplicate.custom-error-msg').hide();
		    	return self.validateSubmitSecond();
		    }

		  });

	

	},

	validateSubmitFirst:function(){
		

		var ignore = [
			    
			    '.chatni_report_no',
			    '.ge__module input',
					'.ge__module input[type=number]',
					'.ge__module select',
					'.ge__module textarea'];


		if(this.entry_type == "OUT"){
			ignore.push('#loaded_weight');
		}

		if(this.entry_type == "IN"){
			ignore.push('.tare_weight');
		}
					
		var firstWeightValidation = { 
			debug:false,
			ignore: ignore.join(','),
			rules: {
			}
		};

		$(".gate-entry-form").validate(firstWeightValidation);

		var valid = $(".gate-entry-form").valid();
		
		if(!valid)
			return $submitBtn.prop( "disabled", false );
		
		$(".gate-entry-form").submit();

	},

	calculateQcCutTotal:function(){
	  var total = 0;
	  var selectBoxes = $('.quality_cut_dd');
	  $.each(selectBoxes, function() {
	  	    var parentTr = $(this).closest('tr');	
	  			total = total + parseInt(parentTr.find('.qc_total').text());
		});
	
		return total;
	},

	validateSubmitSecond:function(){

		var rules = {};
		if(this.entry_type == "OUT"){

		 	rules = {
			   	gate_pass_no:{
			   		gatePassValidationMaterialOut: true
			   	}
			};
			
		}else{
			rules = {
			   	gate_pass_no:{
			   		deductPackMatCheck: true 
			   	}
			};
		}

		var ignore = [];

		if(!window.GATE_ENTRY.moduleDisplay('godown_material_qc_labour_allocation'))
			var ignore = [
			  '#godown_material_qc_labour_allocation.ge__module input',
				'#godown_material_qc_labour_allocation.ge__module input[type=number]',
				'#godown_material_qc_labour_allocation.ge__module select',
				'#godown_material_qc_labour_allocation.ge__module textarea'
			];
			
		

		//Only applying validations if module exits on page

		var secondWeightValidation = {
			debug:false,
			ignore: ignore.join(','),
			rules:rules,
		};

		$(".gate-entry-form").validate(secondWeightValidation);

		//If module is on display then check validation.
			if(window.GATE_ENTRY.moduleDisplay('quality_cut')){
				$(".show_qc_errors").rules("add", { 
				   qcValidate: true,
				});
			}

		//If module is on display then check validation.
		if(window.GATE_ENTRY.moduleDisplay('cmr_details'))
			$("#tp_date").rules("add", { 
			   tpDateValidate: true,
			});


		var valid = $(".gate-entry-form").valid();

		if(!valid){
			 return false;
		}

		//If no quality cut is entered. Then Popup is open to confirm if all quality is Good.
		if(window.GATE_ENTRY.moduleDisplay('quality_cut')){
			 if(!this.calculateQcCutTotal())
			  return swal({
					  title: "Are you sure the Paddy is Ok?",
					  text: "No Moisutre or Quality Cut entered!",
					  icon: "warning",
					  buttons: true,
					  dangerMode: true,
					})
					.then(function(allGood){
						if(allGood) {
					    $(".gate-entry-form").submit();
					  } else {
					     return false;
					  }
					});	
		} 		


		$(".gate-entry-form").submit();		



	},

	validateSubmit: function (){
		//Means user is updating the form pnluy
		if(v('only_edit'))
			return	$(".gate-entry-form").submit();		


		var $submitBtn = $('.submit-entry');

	  if(v('isUpdate'))
	   return this.checkGatePassDuplicacy();
	  else
	  	return this.validateSubmitFirst();

	},

	buildStockItemTypes:function(){
		var self=  this;
		var module = this.getModuleConfig('stock_item_types');
		if(module==null)
			return;
		var stockItems = Store.query(module.stock_groups)
							.column('stock_items')
							.reduce(function(collection, stock_items){
								return collection.concat(stock_items);
							},[]);
		var builtCollection = [];

		$.each(stockItems,function(){
			builtCollection.push(self.hashed({
				'bags'		: '',
				'stock_item'	: this,
			}));
		})

		this.stock_item_types = builtCollection;
	},

	hashed: function(data){
		data._hash = sha1(JSON.stringify(data)+Date.now()+Math.random())
		return data;
	},

	setTareWeight:function(val){
		this.common_fields.tare_weight = val;
		this.weightChange();
	},

	setLoadedWeight:function(val){
		
		this.common_fields.loaded_weight = val;
		this.weightChange();
	},

	weightChange:function(){

		if(this.common_fields.loaded_weight > 0 && this.common_fields.tare_weight >0){

			var wt = this.common_fields.loaded_weight - this.common_fields.tare_weight;
			this.common_fields.gross_weight = wt;
		
			if(this.common_fields.deduct_packing_material)
			  wt = this.common_fields.loaded_weight - this.common_fields.tare_weight - this.computedPackingWeight;
			this.common_fields.net_weight = wt;
		}else{
			this.common_fields.gross_weight = 0;
			this.common_fields.net_weight = 0;
		}


	},

	getModuleConfig:function(module){
		var form = Store.query('forms')
						 .where('id',this.selected_form)
						 .first();

		return Store.query(form.modules)
					 .where('module_id',module)
					 .first();
	},

	chatniReportFlag:function(){
		var form = Store.query('forms')
						 .where('id',this.selected_form)
						 .first();
		return form.chatni_report_no;				 

	},

	moduleQCTypes: function(module){
		return this.getModuleConfig(module).quality_cut_types;		
	},


	bagTypeStockItems:function(type){
		return [];
	},

	moduleStockItems:function(module){
		var stockGroups = this.moduleConfig(module).stock_groups;
		if(module = 'bag_types')

		var stockItems = [];
		$.each(stockGroups ,function(key, group){

			if(group.stock_items)
				stockItems = stockItems.concat(group.stock_items);

		});	

		this.stockItems;
		
	},
	
	qualityCutslist:function(){
		return [];
	},

  moduleDisplay: function (moduleID) {

   var formId = this.selected_form;
   var keys = [];

	   $.each(window.for_js.forms, function(key, item){
	   	  if(item.id == formId){
	   	  	$.each(item.modules, function(k, val){
	   	  		 keys.push(val.module_id);
	   	  	});
	   	  }
	   });
	  
	  return keys.includes(moduleID);
  },
  moduleConfig: function(module){

		var form = Store.query('forms')
			 			.find(this.selected_form);
			   
		return Store.query(form.modules)
					 .where('module_id',module)
					 .first();
	},

	modulePartyJobtypes: function(module, partyIdColumn){
		var jobCats = this.moduleConfig(module).labour_job_categories;
		var partyId = this[module][partyIdColumn];
    	partiesWithJobTypes = window.for_js.labour_parties_with_job_types;
    	var JobTypes = [];
    	$.each(partiesWithJobTypes, function(key, labourPrty){
    		if(partyId == labourPrty.id){
    			JobTypes = labourPrty.labor_party_job_types;
    		}
    	});    	 
		return JobTypes;
	},

	moduleFlatStockItems: function(module){
		var self=  this;
		var module = this.getModuleConfig(module);
		return Store.query(module.stock_groups)
							.column('stock_items')
							.reduce(function(collection, stockItems){
								return collection.concat(stockItems);
							},[]);
	},

	selectLaborJobtype:function(module){
		var self 	= this;
		var module 	= this.getModuleConfig(module);
		var jobTypes = Store.query(module.labour_job_categories)
							 .column('job_types')
							 .reduce(function(collection, jobtype){
								return collection.concat(jobtype);
							},[]);
		return jobTypes;
	},

	selectLaborParty:function(module){
		var self=  this;
		var jobTypes = this.selectLaborJobtype(module);
		var parties = Store.query(jobTypes)
							 .column('parties')
							 .reduce(function(collection, party){
								return collection.concat(party);
							},[]);
		return Store.query(parties).unique().get();
	},

	submitData: function(){
		var equality = [];

		if(this.moduleDisplay('stock_item_types'))
			equality.push(this.computedStockItemsBags);

		if(this.moduleDisplay('bag_types'))
			equality.push(this.computedBagTypesBag);

		if(this.moduleDisplay('godown_material_qc_labour_allocation'))
			equality.push(this.computedQCGodownBags);

		equality = equality.filter(function (e, i, arr) {
		    return arr.lastIndexOf(e) === i;
		});

		if(equality.length > 1)
			return this.validBagsCount = false;

		this.validBagsCount = true;

		if(equality[0] < this.computedQCBags)
			return this.validQCBagsCount = false;

		this.validQCBagsCount = true;
   	this.validateSubmit();	
	},

	_recordsSplitter:function(data_arr,chunk_size){
		return recordsSplitter(data_arr,chunk_size);
	}


};
