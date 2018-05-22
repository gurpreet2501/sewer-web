var cmr = new Vue({
	el: '#add-rate-contracts',
	data: {
		test : 4,
		iterator: {items: [0]},
		hideWeight:1,
		contractType: 'by_end_date',
		'stockGroupId':0
	},
	computed: {

	},
	methods: {
		iteratorInsert: function(index){
			 console.log(this.stockGroups)
			var self = this;
			var lastEle = this.iterator[index][this.iterator[index].length-1];
			this.iterator[index].push(lastEle+1);
			setTimeout(function(){  self.hideElements(); });			
		},

		iteratorRemove: function(index, id){
			var self = this;
			if(this.iterator[index].length <= 1)
				return alert('Cannot delete there should be at-least one entry.');

			this.iterator[index].splice(id - 1, 1);
			
			setTimeout(function(){  self.hideElements(); });
		},

		onContractTypeChange: function(){
			this.iterator.items = [0];
			if(this.contractType == 'by_end_date')
				this.hideWeight = 1;
			else
				this.hideWeight = 0;

		},
	
		filterStockItems:function(){
			var stockItems = [];
			var stockGrpId = this.stockGroupId;
			$.each(v('stockItems'), function(key, value){
				 if(value.stock_group_id == stockGrpId)
				 	 	stockItems.push(value);
			});
			
			return stockItems; 

		}
	}
});
