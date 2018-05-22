<?php $cacheVer = $this->config->item('cache_version'); ?> 
<!DOCTYPE html>
<html>
<head>
  <title><?= isset($title) ? $title . ' - ' : ''; ?>Admin</title>
 <meta charset="utf-8" />
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/bootstrap-date-picker.css?v='.$cacheVer)?>">
 <link rel="stylesheet" type="text/css" href="<?=base_url('assets/css/chosen.css?v='.$cacheVer)?>">
  <link href="<?=base_url('assets/css/bootstrap.min.css?v='.$cacheVer)?>" rel="stylesheet">
  <link href="<?=base_url('assets/css/select2.css?v='.$cacheVer)?>" rel="stylesheet">
  <link href="<?=base_url('assets/css/vex-theme-os.css?v='.$cacheVer)?>" rel="stylesheet">
 <link href="<?=base_url('assets/css/print.css?v='.$cacheVer)?>" rel="stylesheet">
<?php 
if(isset($css_files)){
    foreach($css_files as $file): ?>
    	<link type="text/css" rel="stylesheet" href="<?=$file.'?v='.$cacheVer?>" />
    <?php endforeach; 
 }
?>
 <link href="<?=base_url('assets/css/sb-admin.css?v='.$cacheVer)?>" rel="stylesheet">
 <link href="<?=base_url('assets/css/style.css?v='.$cacheVer)?>" rel="stylesheet">
 

<style type='text/css'>
body
{
	font-family: Arial;
	font-size: 14px;background:#fff;
}
a {
    color: blue;
    text-decoration: none;
    font-size: 14px;
}
a:hover
{
	text-decoration: underline;
}
.form-control {
  height: 29px;
}

.cancel-reason.form-control {
  height: auto !important;
}
</style>
</head>
<body>
	<div class="container">
	<div class="row">
		<div class="col-xs-12">
			<table class="table table-boxed">
				<tr>
					<th>Error</th>
					<th>File Name</th>
					<th>Line No</th>
					<th>Function input vars</th>
					<th>Created Date</th>
				</tr>
				<?php foreach ($errors as $key => $error): ?>
					<tr>
						<td align="center"><?php echo "<pre>"; var_export(unserialize($error->error));  echo "</pre>";?></td>
						<td><?=$error->file_name?></td>
						<td><?=$error->line_no?></td>
						<td><?php echo "<pre>"; var_export(unserialize($error->function_input)); echo "</pre>";?></td>
						<td><?=date('d M, Y H:i A',strtotime($error->created_at))?></td>
					</tr>
					
				<?php endforeach ?>
			</table>
			<div class="pagination pull-right">
				<?php if ($errors->currentPage() != 1): ?>
					<a href="<?=site_url('errors/printing'.$errors->previousPageUrl())?>"><button class="btn btn-danger" type="button">Previous</button></a>
				<?php endif ?>
				<?php if($errors->currentPage() != $errors->lastPage()): ?>
					<a href="<?=site_url('errors/printing'.$errors->nextPageUrl())?>"><button class="btn btn-danger" type="button">Next</button></a>
			  <?php endif; ?>
			</div>
		</div>		
	</div>
</div> <!-- container -->
</body>
<?php $this->load->view('admin/partials/footer'); ?>
