window._VUE_APP_GATE_ENRTY.computed = {
	computedStockItemsBags:function(){
		return Store.query(this.stock_item_types).sum('bags');
	},

	computedBagTypesBag:function(){
		return Store.query(this.bag_types).sum('bags');
	},

	computedQCGodownBags:function(){
		return Store.query(this.godown_material_qc_labour_allocation).sum('bags');
	},

	computedQCBags:function(){
		return Store.query(this.quality_cut).sum('bags');
	},

	computedPackingWeight:function(){
		var sum = 0;
		var self= this;
		$.each(this.bag_types,function(){
			var bags = parseFloat(this.bags);
			if(!this.stock_item.bag_weight)
				return;
			var tempSum = (bags*this.stock_item.bag_weight.weight)
			sum += self.NaNsafe(tempSum);
		});
		return sum.toFixed(2);
	},

	netWeight: function(){
		if(this.deductPackingMaterial)
			return this.grossWeight-this.packingMaterialWeight;
		return this.grossWeight;
	},
	grossWeight: function(){
		 console.log(this.loadedWeight)		
		if(this.loadedWeight && this.tareWeight)
			return this.loadedWeight-this.tareWeight;
		// return 0;
	},

	validBagCountTypeStyle:function(){

		if(!this.validBagsCount)
			return {border: '2px solid red'};

		return {};
	},

	validQcBagsCountStyle:function(){

		if(!this.validQCBagsCount)
			return {border: '2px solid red'};

		return {};
	},

	__loadedWeight: function(){
		if((this.entryType=='IN') && !v('isUpdate'))
			return this.comWeight;
		if((this.entryType=='OUT') && v('isUpdate'))
			return this.comWeight;
		if(v('isUpdate'))
			return v('gate_entry').loaded_weight; 
		// return 0;
	},

  bagsTotalMaterialGodAlloc:function(){
  	var total = 0;
  	$.each(this.godown_material_qc_labour_allocation, function( index, value ) {
  		if(!value.bags)
  			bagCount = 0;
  		else
  			bagCount = value.bags;
		  total = total + parseInt(bagCount);
		});
		
		return total;
	},


	__tareWeight: function(){
		if((this.entryType=='OUT') && !v('isUpdate'))
			return this.comWeight;
		if((this.entryType=='IN') && v('isUpdate'))
			return this.comWeight;
		if(v('isUpdate'))
			return v('gate_entry').tare_weight; 
		// return 0;
	},

	forms: function(){
		var self = this;
		var forms = Store.query('forms')
						 .where('type',self.entryType)
						 .get();
		return forms;
	},


	jobTypes: function(){
		var self = this;
		var laboutJobTypes = [];
		var filtered = $.grep(window.for_js.labour_parties_with_job_types, function(item){
			if(self.labourParty == item.id){
				laboutJobTypes = item.labour_job_types;
			}
		});
		return laboutJobTypes;
	},	

	formsDisplay: function(){
		return Boolean(this.entryType);
	},

	// common_fields:{
	// 	net_weight :function(){
	// 		return 10;
	// 	} 
	// }

};
