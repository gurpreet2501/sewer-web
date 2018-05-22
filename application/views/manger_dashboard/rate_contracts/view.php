<? $this->load->view('admin/partials/header') ?>

<?php if (isset($_GET['alert'])): ?>
	<div class="alert alert-success"><?= $_GET['alert'] ?>	</div>
<?php endif; ?>

<a href="<?= site_url('manager_dashboard/add_rate_contracts') ?>" class="btn btn-success pull-right">Add Rate Contract</a>

<div class="row">
  <div class="col-lg-12">
    <?php echo $output;  ?>
  </div>
</div>
<? $this->load->view('admin/partials/footer') ?>
