<form class="form-inline" id="filter-select" name="filter-select">	
	<div class="row pull-right">
	  <div class="col-lg-12">
			  	<div class="form-group">
					  <label for="start_date">Start Date</label>
						<input type="text" id="start_date" class="form-control force-extend _datepicker" name="from_date" placeholder="Select Start Date"  value="<?=$from_date?>"/>
					</div>	
					<div class="form-group">
					  <label for="end_date">End Date</label>
						<input type="text" class="form-control force-extend _datepicker" name="to_date" placeholder="Select End Date" id="end_date" value="<?=$to_date?>" />
					</div>
			  	<button type="submit" class="btn btn-success" name="date_filter">Go</button>
			  	<!-- <button type="submit" class="btn btn-success" name="_today_filter">Generate For Today</button> -->
	  </div> <!-- col-lg-10 -->
	</div> <!-- row -->
</form>	
<br>
