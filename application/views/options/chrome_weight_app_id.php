<?php $this->load->view('admin/partials/header');  ?>

<div>
	<div class="row">
    <div class="text-center">
      <h2>Add your Chrome Weight id</h2>
    </div>
    <div class="col-md-6 col-md-offset-3 text-center">
      <?php if ($success): ?>
        <div class="alert alert-success">App id saved successfully.</div>
      <?php endif; ?>
    <form class="form-inline" action="" method="post">
      <div class="form-group">
        <div class="input-group">
          <input type="text" name="chrome_weight_app_id" class="form-control" placeholder="Chrome weight id" style="min-width: 440px;padding: 18px 14px;" value="<?= @$value ?>">
        </div>
      </div>
      
        <br />
        <br />
        <button type="submit" class="btn btn-primary">Save</button>
      
    </form>
    </div>
	</div><!-- row -->
</div>
<?php $this->load->view('admin/partials/footer'); ?>
 
