<style type="text/css">
 .table { display: table; width: 100%; border-collapse: collapse; }
    .table-row { display: table-row; }
    .table-cell { display: table-cell; border: 1px solid black; padding: 1em; }
    .text-center{
    	text-align: center
    } 
</style>
<div class="col-xs-6">
	<h2>Credit Entries</h2>
	<hr/>
	<?php if(count($entries['credit'])): ?>
	<table class="table table-stripped  text-center">
		<tr class="table-row">
			<th class="table-cell">ID</th>
			<th class="table-cell">Account name</th>
			<th class="table-cell">Secondary Account name</th>
			<th class="table-cell">Amount</th> 
			<th class="table-cell">Remarks</th>
			<th class="table-cell">Transaction Date</th> 
		</tr>

	<?php foreach($entries['credit'] as $entry): ?>	
		<tr class="table-row">				
			<td class="table-cell"><?=$entry->id ?></td>
			<td class="table-cell"><?=$entry->primaryAccount->name ?></td>
			<td class="table-cell"><?=$entry->secondaryAccount->name ?></td>
			<td class="table-cell"><?=$entry->amount ?></td>
			<td class="table-cell"><?=$entry->remarks ?></td>
			<td class="table-cell"><?=$entry->transaction_date ?></td> 
		</tr>
		<?php endforeach; ?>	
	</table>

<?php else: ?>

	<div class="text-center"><h4>No Records Found</h4></div>
<?php endif; ?>
</div><!-- col-xs-6 -->

<div class="col-xs-6">
	<h2>Debit Entries</h2>
	<hr/>
	<?php if(count($entries['debit'])): ?>
	<table class="table table-stripped text-center">
			<tr class="table-row">
				<th class="table-cell">ID</th>
				<th class="table-cell">Account Name</th>
				<th class="table-cell">Secondary Account name</th>
				<th class="table-cell">Amount</th>
				<th class="table-cell">Remarks</th>
				<th class="table-cell">Transaction Date</th> 
			</tr>
		<?php foreach($entries['debit'] as $entry): ?>
			<tr class="table-row">				
				<td class="table-cell"><?=$entry->id ?></td>
				<td class="table-cell"><?=$entry->primaryAccount->name ?></td>
				<td class="table-cell"><?=$entry->secondaryAccount->name ?></td>
				<td class="table-cell"> <?=$entry->amount ?></td>
				<td class="table-cell"><?=$entry->remarks ?></td>
				<td class="table-cell"><?=$entry->transaction_date ?></td>
			</tr>
 		<?php endforeach; ?>	
		</table>
	<?php else: ?>
		<div class="text-center"><h4>No Records Found</h4></div>
	<?php endif; ?>
	</div>
