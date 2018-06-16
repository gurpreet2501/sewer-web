<?php $this->load->view('admin/partials/header'); ?>
<div class="row">
	<div class="col-xs-12">
		<h1 class="text-center">MACHINES</h1>
		 <table class="table table-bordered">
		 		<tr>
		 				<td>#Serial</td>
		 				<td>Name</td>
		 				<td>Status</td>
		 				<td>Button Status</td>
		 				<td>Is Blocked By Admin</td>
		 		</tr>
		<?php foreach ($data as $key => $item):	 ?>
			<tr>
				<td><?=$item->machine_serial?></td>
				<td><?=$item->machine_name?></td>
				<td><?=$item->status ? 'ON' : 'OFF'?></td>
				<td><?=$item->button_status ? 'ENABLED': 'DISABLED'?></td>
				<td><?=$item->blocked ? 'Yes' : 'No'?></td>
			</tr>
		<?php endforeach ?>
		 		
		 </table>
			
	</div>
</div>	
<?php $this->load->view('admin/partials/footer'); ?>
