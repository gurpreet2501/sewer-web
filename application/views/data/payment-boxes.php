<div class="row">
	 <div class="col-xs-9"></div>
	 	<div class="col-xs-3 pull-right">
		  	<h4>Advance Payment: Rs. <span class="advance_payment"><?=$advance_payment?></span></h4>
	 	</div>
 </div> <!-- row -->
 <br/>
 <div class="row">
 <div class="col-xs-7">
 	  <!-- <button class="btn btn-success pull-right" name="submit_btn" type="submit">Update Rates</button> -->

 	</div>
 	<div class="col-xs-2">
 			<label>From Payment Account</label>
 			<input type="text" name="amount" readonly class="form-control amount_to_pay" placeholder="Select Jobs" />
 			<label>From Advance</label>
 			<input type="text" name="from_advance" readonly class="form-control amount_to_pay_from_advance" placeholder="Select Jobs" />
 	</div>

 	<div class="col-xs-2">
 				<label>Select Payment Account</label>
	  		<select class="form-control" name="source_payment_account">
		  		<?php foreach (cashTransactionMenuItems() as $item): ?>
	          <option value="<?=$item->id?>"><?=$item->name?></option>
	        <?php endforeach; ?>
        </select>       
        <br />
        <button class="btn btn-primary btn-block" type="submit" name="payment_btn">Pay</button>   
 	</div>
 </div> <!-- row -->
