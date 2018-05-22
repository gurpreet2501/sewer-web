<? $this->load->view('admin/partials/header') ?>

<div class="row">
  <div class="col-lg-12">
  	<h3 class="text-center"><?=!empty($title) ? $title : ''?></h3>
  </div>
</div>  	
<div class="row">
  <div class="col-lg-12">
    <?php echo $output;  ?>
  </div>
</div>
<? $this->load->view('admin/partials/footer') ?>
