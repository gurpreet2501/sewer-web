<?php

?>
<tr class="labAcc">
	<td>&nbsp;</td>
	<td><?=$entry['labour_job_type_name']?></td>
	<td width="10%">
		<input type="text" class="form-control labour_acc_rate " readonly value="<?=$entry['rate']?>" />
	</td>
	
	<?php foreach($godowns as $godown): ?>
		<td class="bag_exists">
			<?=($entry['godown_id'] == $godown->id) ? $entry['bags']: 0;?>
		</td>
	<?php endforeach; ?>

	<td><div class="labour_acc_entry_total">0</div></td>
</tr>
