<link rel="stylesheet" href="<?=base_url('assets/css/bootstrap.min.css')?>" />
<style type="text/css">
	.title{
		font-size: 18px;
		font-weight: bold
	}
</style>
<div class="container">
  <div class="row">
		  <div class="col-xs-12 text-center">
				<div class="content">
					<div class="text-center">
						<h3>Navdanya Foods Pvt. Ltd.</h3>
						<p> At.- Govindpur, <br>
							P.O./Dt.-Bargarh. 768028. <br>
							Odisha. India.
						</p>
						<p>CIN: U15312OR2000PTC006047</p>
						<p>Ledger Account</p>
						<p><?= $make_date($from_date)?> to <?= $make_date($to_date) ?> </p>
						<br><br>
					</div>
				</div>
		 </div> <!-- col -->
 </div> <!-- row ends -->
<div class='row'>
	<div class="col-xs-6">
	  <div class="stock-total pull-right"><h4><?=$opening_stock_total?></h4></div>
		<div class="title">Opening Stock</div> 
		<?php foreach($opening_closing_stock_total as $val): 
				if(!$val['opening_stock_total'])
					continue;
		?>
			   <table class="table table-stripped">
			   		<tr>
			   			<td><?=$val['stock_group_name']?></td>
			   			<td align="right"><?=$val['opening_stock_total']?></td>
			   		</tr>
			   </table>
		<?php endforeach; ?>
	</div>
	<div class="col-xs-6">
	  <div class="stock-total pull-right"><h4><?=$closing_stock_total?></h4></div>
		<div class="title">Closing Stock</div>
		<?php foreach($opening_closing_stock_total as $val): 
				if(!$val['closing_stock_total'])
					continue;
		?>
			   <table class="table table-condensed">
			   		<tr>
			   			<td><?=$val['stock_group_name']?></td>
			   			<td align="right"><?=$val['closing_stock_total']?></td>
			   		</tr>
			   </table>
		<?php endforeach; ?>
	</div>
</div>	  <!-- row -->

<div class="row">
	<div class="col-xs-6">
		<div class="stock-total pull-right"></h4></div>
		<div class="title">Sales Accounts</div> 
		<?php foreach ($sales_acc_report as $key => $va):?>
			   <table class="table table-stripped">
			   		<tr>
			   			<td><?=$va['account_name']?></td>
			   			<td align="right"><?=$va['amount']?></td>
			   		</tr>
			   </table>
		<?php endforeach; ?>
	</div>
	<div class="col-xs-6">
		<div class="stock-total pull-right"></h4></div>
		<div class="title">Purchase Accounts</div> 
		<?php foreach ($purchase_acc_report as $key => $va):?>
			   <table class="table table-stripped">
			   		<tr>
			   			<td><?=$va['account_name']?></td>
			   			<td align="right"><?=$va['amount']?></td>
			   		</tr>
			   </table>
		<?php endforeach; ?>
	</div>
</div>

<div class="row">
		<?php foreach($categories as $cat_slug => $category){?>
			<div class="col-xs-6">
			   <?php	$catAccounts = isset($accounts[$cat_slug]) ? $accounts[$cat_slug] : []; ?>
		  			   <div class="title"><?=$category['name']?></div>
					<?php foreach($catAccounts as  $ac){
							$transactionSum = Models\Transactions::getTransactionByType($category['type'], $from_date, $to_date, $ac['id'])
												 ->orderBy('id', 'DESC')
												 ->sum('amount');  
									if(!$transactionSum)			 
										continue;
						?>

					<table class="table table-condensed">
						<tr>
							<td><?=$ac['name']?></td>
							<td align="right"><?=$transactionSum?></td>
						</tr>
					</table>							 
		<?php } ?>
	    </div> <!-- col-xs-6 -->
<?php } ?>
</div>



</div> <!-- container -->
<!-- ----------------- -->


</div>
<br/>
<br/>
