<?php $this->load->view('admin/partials/header');?>
<div class="container">
	<div class="row">
		<div class="col-xs-4"></div>
		<div class="col-xs-4">
			<h3>Enter Chatni Report No</h3>
			<form action="<?=site_url('gate_entry/chatni_report_bags_post')?>" method="get" class="validate">
				<div class="form-group">
					<input type="text" name="chatni_report_no" class="form-control required" />
				</div>
				<input type="submit" value="Find" class="btn btn-danger full-width" />
			</form>
		</div>
		<div class="col-xs-4"></div>
	</div> <!-- row -->
	 <?php if(count($entries)): 
					$this->load->view('gate_entry/issue_chatni_bags');
        endif; 
   ?>
	</div>
<?php $this->load->view('admin/partials/footer');?>