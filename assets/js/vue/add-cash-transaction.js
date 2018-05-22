window.CASH_TRANSACTIONS= new Vue({
	el: '#add-cash-transaction',
	data: {
					transactions: [],
 				  
 				  credit:{
 				  	amount: [], party_ids: []
 				  },
				  debit:{
				  	amount: [], party_ids: []
				  },
				  accounts: window.for_js.accounts,
				  primary_account:v('primary_account_id')
	   	 },

	computed: {},

	watch:{
			transactions:{
				handler:function(new_val){
					 var fromDate = $('.from_date').val()+' 00:00:00';
			  	 var toDate = $('.to_date').val()+' 23:59:59';
		  	 	 $.each(new_val, function(key, val){
		  	 	 	  //Convert Amount to Comma format using momentjs library

		  	 	 	//   var number = numeral(val.amount);
					    // val.amount = number.format('0,0');
					    val.amount = INRFormat(val.amount);

					    //Validating Date
		  	 	 		var isSameAsFromDate = moment(val.transaction_date).isSame(fromDate);
		  	 	 		var isSameAsToDate = moment(val.transaction_date).isSame(toDate);
		  	 	 		var isBefore = moment(val.transaction_date).isBefore(toDate);
		  	 	 		var isAfter = moment(val.transaction_date).isAfter(fromDate);
							if(val.transaction_date){
					  	    if(!((isBefore && isAfter) || isSameAsFromDate || isSameAsToDate))
					  	    	val.date_valid = false
					  	    else 	
					  	    	val.date_valid = true
							}else{
								val.date_valid = true; // making it true for empty fields that load first time.
							}

		  	 	 });
				},
				deep:true
			},
	},

	methods: {
		
		transactionsFilter:function(type){
			var transactions = [];
			obj = this;
			$.each(this.transactions, function(key, transRecord){

				if((transRecord.primary_account_id == obj.primary_account)
					&& (type=='DEBIT'))
				  	transactions.push(transRecord);

				if((transRecord.secondary_account_id == obj.primary_account)
					&& (type=='CREDIT'))
				  	transactions.push(transRecord);

			});

			return transactions;

		},

		agDropDownInputCallBack:function(index, nextFieldClass){
			 var vm = this;
  		 var nextField = $(vm).find('.' + nextFieldClass);
			  $('tr#'+index+' .'+nextFieldClass).focus()
		},

		convertToNumerals:function(amount){
			return amount.replace(/,/gi, "");
	  	},

		transactionDateStyle:function(valid){
			if(!valid)
				return {border:'2px solid Red'}
			else
				return {}
		},

		iteratorInsert: function(index){
			var self = this;
			var lastEle = this.iterator[index][this.iterator[index].length-1];
			this.iterator[index].push(lastEle+1);
		},

		insertTransactions: function(record){
			 
    		var dateString = this.getDateString();
    		if(!record.transaction_date)
    			record.transaction_date = dateString;

				var hash = sha1(JSON.stringify(record)+Date.now()+Math.random());
				record.hash = hash;

				this.transactions.push(record);
		},

		removeTransaction: function(hash){
				var trans = this.transactions;
				$.each(trans, function(key, value){
					 if(hash == value.hash){
					 	  trans.splice(key,1);
					 	  return false;
					 }
				});

				this.transactions = trans;
	  },

	  insertEmptyTransaction: function(type){
			var data = {
				'date_valid':true,
				'id':0,
				'primary_account_id':0,
				'secondary_account_id':0,
				'amount':0,
				'transaction_date':'',
				'remarks':''
			};
	    
	    if(type == 'CREDIT')
	    		data.secondary_account_id = this.primary_account;
	    	else
	    		data.primary_account_id = this.primary_account;

			return window.CASH_TRANSACTIONS.insertTransactions(data);
		},

	  totalDebit:function(){
	  	var credit = 0.00;
	  	obj = this;
	  	$.each(this.transactions, function(key, value){
	  		 if(value.primary_account_id == obj.primary_account){
	  		 	if (value.amount == '')
	  		 		return;

	  		 	var amount = obj.convertToNumerals(value.amount);
	  		 	credit = credit + parseFloat(amount);	  		 	
	  		 	if(isNaN(credit))
	  		 	  credit = 0.00;
	  		 }
	  	});
	  	return INRFormat(credit);
	  	return numeral(credit).format('0,0');
	  },

	  totalCredit:function(){
	  	var debit = 0.00;
	  	var primary_acc_id = this.primary_account;
	  	$.each(this.transactions, function(key, value){
	  		if(value.secondary_account_id == primary_acc_id){
	  			if (value.amount == '')
	  		 		return;
	  		 	 var str = value.amount;
					 var amount = str.replace(/,/gi, "");
	  		 	 debit = debit + parseFloat(amount);
	  		 	 if(isNaN(debit))
	  		 	 	debit = 0.00;
	  		 }
	  	});
	  	
	  	return INRFormat(debit);
	  	return numeral(debit).format('0,0');
	  },

	  getDateString:function(){
	  	 var newDate = new Date();  
				var dateString = '';
				// Get the month, day, and year.  
				dateString += newDate.getFullYear()+ "-";
				if(newDate.getMonth()<=9)
					dateString += '0'+(newDate.getMonth() + 1) + "-";  
				else
					dateString += (newDate.getMonth() + 1) + "-";  

				  dateString += newDate.getDate(); 
				  return dateString;
	  },

	  closingBalance:function(){
	  	 var closing_balance = this.convertToNumerals(window.for_js.openingBalance);

	  	 var credit = this.convertToNumerals(this.totalCredit()) * 1;
	  	 var debit = this.convertToNumerals(this.totalDebit()) * 1;
	  	 closing_balance =  parseFloat(closing_balance) + parseFloat(credit) - parseFloat(debit);
	  	 /*console.log('closing'+closing_balance);
	  	 console.log('credit'+credit);
	  	 console.log('deb'+debit);*/
	  	 return INRFormat(closing_balance);
	  	 return numeral(closing_balance).format('0,0');
	  },

		iteratorRemove: function(index, id){
			if(this.iterator[index].length <= 1)
				return alert('Cannot delete there should be at-least one entry.')
			this.iterator[index].splice(this.iterator[index].indexOf(id), 1);
		},

		onSubmit: function(e){
		},

		calculateBalance: function(e){
			$('#add-cash-transaction form').submit();
		}
	}
});

jQuery(function(){
	var dateString = window.CASH_TRANSACTIONS.getDateString();
	$.each(v('transactions'), function(key, value){
	  window.CASH_TRANSACTIONS.insertTransactions(value);
	});
	window.CASH_TRANSACTIONS.insertEmptyTransaction('CREDIT');
	window.CASH_TRANSACTIONS.insertEmptyTransaction('DEBIT');
});
