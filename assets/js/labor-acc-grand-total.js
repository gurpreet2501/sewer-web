jQuery(function(){

	var total_paid_amount = 0.00;
	var total_amount_due = 0.00;
	var ge_job_amount_paid = 0.00;
	var cjobs_amount_paid = 0.00;
	var ojobs_total_amt_paid = 0.00;
	var cjobs_amount_due = 0.00;
	var ojobs_total_amt_due = 0.00;
	var ge_job_amount_due = 0.00;
	
	ge_job_amount_paid = $('.ge_job_amount_paid').length ? $('.ge_job_amount_paid').html() : 0.00;
	cjobs_amount_paid = $('.cjobs_amount_paid').length ? $('.cjobs_amount_paid').html() : 0.00;
	ojobs_total_amt_paid = $('.ojobs_total_amt_paid').length ? $('.ojobs_total_amt_paid').html() : 0.00;

	ge_job_amount_due = $('.ge_job_amount_due').length ? $('.ge_job_amount_due').html() : 0.00;
	cjobs_amount_due = $('.cjobs_amount_due').length ? $('.cjobs_amount_due').html() : 0.00;
	ojobs_total_amt_due = $('.ojobs_total_amt_due').length ? $('.ojobs_total_amt_due').html() : 0.00;
	

	total_paid_amount = parseFloat(ge_job_amount_paid)+parseFloat(cjobs_amount_paid)+parseFloat(ojobs_total_amt_paid);
	total_amount_due = parseFloat(ge_job_amount_due)+parseFloat(cjobs_amount_due)+parseFloat(ojobs_total_amt_due);
	
	$('.gd-total-paid span').text(total_paid_amount);
	$('.gd-total-due span').text(total_amount_due); 
	
});