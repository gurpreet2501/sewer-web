<?php $this->load->view('admin/partials/header'); ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-4">
				<div class="map-overlay">
					<h4 class="text-center">
						Machine Details
					</h4>
					<table class="table table-bordered">
						<tr>
							<td>Name</td>
							<td><?=$data->machine_name?></td>
						</tr>
						<tr>
							<td>Serial</td>
							<td><?=$data->machine_serial?></td>
						</tr>
						<tr>
							<td>Type</td>
							<td><span class="label label-danger"><?=$data->type?></span></td>
						</tr>
						<tr>
							<td>Status</td>
							<td><?=$data->status == 1 ? '<span class="label label-success">ENABLED</span>' : '<span class="label label-danger">DISABLED'?></td>
						</tr>
						<tr>
							<td>Blocked/Unblocked</td>
							<td><input class="machine_blocked_status" data-machine-serial="<?=trim($data->machine_serial)?>" data-on="Unblocked" data-off="Blocked" data-onstyle="success" data-offstyle="danger" 
					<?=($data->blocked == 0) ? 'checked' : ''?> data-toggle="toggle" data-onstyle="warning" data-offstyle="info" type="checkbox"></td>
						</tr>
						
						<?php if($data->type == 'GAS'): ?>
							<tr> 
								<td>Button Status</td>
								<td><input data-machine-serial="<?=trim($data->machine_serial)?>" class="button_status" data-on="Enabled" data-off="Disabled" data-onstyle="success" data-offstyle="danger" 
							<?=($data->button_status ==1) ? 'checked' : ''?> data-toggle="toggle" data-onstyle="warning" data-offstyle="info" type="checkbox"></td>
							</tr>
						<?php endif; ?>
						<tr>
							<td>Address</td>
							<td><?=$data->address->address.', '.$data->address->city.', '.$data->address->state.', '.$data->address->zip.'.'?></td>
						</tr>
					</table>			
				</div>

		</div>
	</div>
</div>
<div id="map" style="height:100%;width:100px;margin:0 auto;"></div>

<script type="text/javascript">

  	
	    window.for_js = {};
      <?php if(isset($for_js)): ?> 
        window.for_js = <?=json_encode($for_js)?>; 
      <?php endif; ?>
      function v(key,_default){
        if(window.for_js[key])
          return window.for_js[key];
        return _default;
      }


    // Initialize and add the map
    function initMap() {
      // The location of Uluru
     var coordinates = {lat: parseFloat(v('latitude')), lng: parseFloat(v('longitude'))};
      // The map, centered at Uluru
      var map = new google.maps.Map(
          document.getElementById('map'), {zoom: 18, center: coordinates});
      // The marker, positioned at Uluru
      var marker = new google.maps.Marker({position: coordinates, map: map});
    }


</script>

<?php $this->load->view('admin/partials/footer'); ?>