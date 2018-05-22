<br>
<div class="row">
	<div class="col-xs-12">
	<form method="post" action="<?=site_url('gate_entry/issue_bags')?>" id="isseu_bags">
		<table class="table table-hover">
			<tr>
				<th>Bag Name</th>
				<th>Pending</th>
				<th>Issued Bags</th>
				<th>Total</th>
				<th>Issue Bags</th>
			</tr>
			<?php if(!isset($entries->bagTypes) || count($entries->bagTypes) == 0 ):?>
						<h2 class="text-center">No Record Found</h2>
			<?php endif; ?>
				<?php foreach ($entries->bagTypes as $key => $bgtype):
									$total_bags = $bgtype->bags;
									$issued_bags = getTotalIssuedBags($bgtype->id);
				 					$pending_bags = $total_bags - $issued_bags; ?>
					<tr>
						<th><?=$bgtype->stockItem->name?></th>
						<th><?=$pending_bags == 0 ? '<span class="label label-success">Complete</span>' : $pending_bags?></th>
						<th><?=$issued_bags?></th>
						<th><?=$total_bags?></th>
						<th width="10%"><input type="text" name="bag_type[<?=$bgtype->id?>][issued_bags]" value=0 class="form-control"  /></th>
					</tr>
				<?php endforeach ?>	
				
	   	</table>
	   	<div class="clearfix">
	   	  <input type="hidden" value="<?=$entries->chatni_report_no?>" name="chatni_report_no" class="btn-btn-success"/>
				<input type="submit" value="Issue Bags" class="btn btn-success pull-right"/>
	   	</div>
    </form>	
	</div>
</div>