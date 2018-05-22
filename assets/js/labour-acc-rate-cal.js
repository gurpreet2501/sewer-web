jQuery(function($){
    
    function calculateTotals(data){
    	var amountDue = 0;
    	var advancePayment = parseFloat($('.advance_payment').text());
    	$('.select_for_payment:checked').each(function(){
    		var $check = $(this);
    		amountDue += parseFloat($check.parent().parent().find('.amount_due').text());
    	});

    	var from_advance = advancePayment;
    	var amtDueAfterAdv = amountDue - advancePayment;

    	if(amtDueAfterAdv < 0)
    		from_advance = amountDue;

    	var fromAccount = amtDueAfterAdv;
    	if(fromAccount < 0)
    		fromAccount = 0;
    	$('.amount_to_pay').val(numeral(fromAccount).format('0,0.00'));
    	$('.amount_to_pay_from_advance').val(numeral(from_advance).format('0,0.00'));
    	return;
      

    }

    //Calculating totals on keyUp when rate is entered
	  $('.select_for_payment').click(function(){
	  	calculateTotals();
	  });
	  calculateTotals()



});		 
