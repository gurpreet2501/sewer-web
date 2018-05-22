<style>
	tr,th,a,p{
		font-family: Arial;
	}
	
	.content{
		width: 900px;	
		margin: auto;
	}
	.text-center{
		text-align: center;
	}
	.table{
		margin: auto;
	}
	.border-bottom{
		border-bottom: 1px solid black;
	}
	.border-top{
		border-top: 1px solid black;;
	}
	.bold{
		font-weight: bold;
	}
	p,h2{
		padding: 0px;
		margin: 0px;
	}
	
	
</style>
<div class="content">
    
	<div class="text-center">
		<h3>Navdanya Foods Pvt. Ltd.</h3>
		<p> At.- Govindpur, <br>
			P.O./Dt.-Bargarh. 768028. <br>
			Odisha. India.
		</p>
		<p>CIN: U15312OR2000PTC006047</p>

		<h2><?= $primary_account->name ?></h2>
		<p>Ledger Account</p>
		<p><?= $make_date($from_date) ?>	to <?= $make_date($to_date) ?></p>
		<br><br>
	</div>

  <table class="table" cellpadding="3" cellspacing="3">
    <thead>
      <tr class="heading">
        <th class="border-bottom border-top">Date</th>
        <th class="border-bottom border-top"></th>
        <th class="border-bottom border-top">Particulars</th>
        <th class="border-bottom border-top">Vch Type</th>
        <th class="border-bottom border-top">Vch No</th>
        <th class="border-bottom border-top">Debit</th>
        <th class="border-bottom border-top">Credit</th>
      </tr>
    </thead>
    <tbody>
    	<tr>
	      	<td><?= $make_date($from_date) ?></td>
	      	<td>Cr</td>      	      	
	        <td class="bold">&nbsp;&nbsp;&nbsp;Opening Balance &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
	        <td></td>
	        <td></td>
	        <td class="bold" align="center"> <?=$opening_balance ?></td>
	        <td></td>
	      </tr>

	<?php 	

	 foreach ($records->toArray() as $record):
	 		$creditEntry = ($record['primary_account_id'] == $primary_account->id) ? true : false; ?>
      <tr>
      	<td><?= $make_date($record['created_at']) ?></td>
      	<td><?=($creditEntry ==1) ? 'Dr' : 'Cr' ?></td>
        <td align="center" class="bold"><?=($creditEntry == true) ? $record['secondary_account']['name'] : $record['primary_account']['name'] ?></td>        
      	<td>--</td>
        <td>--</td>
        <?php if($creditEntry): ?>
        <td align="center"><?=$record['amount']?></td>
        <td></td>
	      <?php else: ?>
      	<td></td>
        <td align="center"><?=$record['amount']?></td>
	      <?php endif; ?>

      </tr>
	<?php endforeach; ?>

	<tr>
		<td></td>
		<td></td>      	      	
		<td></td>
		<td></td>
		<td></td>
		<td class="border-top"><?= $debit_total ?></td>
		<td class="border-top"><?= $credit_total ?></td>
	</tr>

	<tr>
		<td></td>
		<td>Dr</td>
		<td  class="bold">Closing Balance</td>      	      	
		<td></td>
		<td></td>
		<td></td>
		<td><?= number_format($credit_total - $debit_total, 2) ?></td>
	</tr>

	<tr>
		<td></td>
		<td></td>      	      	
		<td></td>
		<td></td>
		<td></td>
		<td class="bold border-bottom border-top"><?=$credit_total ?></td>
		<td class="bold border-bottom border-top"><?=$credit_total ?></td>	
	</tr>
    </tbody>
  </table>
</div>
