<?php $this->load->view('admin/partials/header'); ?>
<h2 class="text-center">Gate Entry Differences</h2>
		<?php if(!count($data)):
					 echo "<h3 class='text-center'>No changes/ additions found.</h3>";
		      else:
					foreach ($data as $key => $diff_entr): 
					$mod_data = json_decode($diff_entr['data']);?>
					
						<div class="light-color-back">
							<div class="row">
							<div class="col-md-3">
								<h3><div class="sub-title">Gate Entry ID: #<?=$diff_entr['gate_entry_id']?></div></h3>
								<h5><div class="sub-title">Changes made by : 
									<strong><?=strtoupper(getUsernameById($diff_entr['user_id']))?></strong>
									</div>
								</h5>
								<div class="sub-title">Entry Edited At: <?=date('d M, Y H:i:s',strtotime($diff_entr['edited_at']))?></div>
							</div>
							<div class="col-md-9">
								<div class="blob-desc">
									<div class="row">
									<?php foreach ($mod_data as $mod_name => $differences): ?>
										<?php foreach ($differences as $key => $diff): ?>

													<div class="col-md-6">
														<div class="white-back clearfix">

																<?php 

																if($diff->diff == 'CHANGED')
																	$this->load->view('manger_dashboard/changed-entries-diff',[
																		'mod_name' => $mod_name,
																		'diff' => $diff
																		]);
																else if ($diff->diff == 'ADDED')
																	$this->load->view('manger_dashboard/added-entries-diff',[
																		'mod_name' => $mod_name,
																		'diff' => $diff
																		]);


																	?>
														</div> <!-- white-back -->
													</div>
									
										<?php endforeach ?>
										<div class="margin-top-10"></div>
									<?php endforeach ?>
								
									</div> <!-- row -->
								</div> <!-- blob-desc -->
							</div>
						</div>
					</div>	
						<hr>
		<?php endforeach;
	     endif;
		 ?>	

<?php $this->load->view('admin/partials/footer'); ?>
