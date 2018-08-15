     
            </div>
            <!-- /.container-fluid -->

        <div class="spacer-100"></div>
        </div>
        <!-- /#page-wrapper -->

    </div>  
    <!-- /#wrapper -->

    <!-- jQuery -->
<?php $cacheVer = rand(1,1000)*2 ?>

 <script src="<?=base_url('env.js?v='.$cacheVer);?>"></script> 
 <script src="<?=base_url('assets/js/env-support.js?v='.$cacheVer);?>"></script> 

 <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC2arTN-uT9iZ4kRF2AQR1JINIwphW8we8&callback=initMap">
    </script>



 <script src="<?=base_url('assets/js/jquery.js?v='.$cacheVer);?>"></script>
 <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
 
 <script src="<?=base_url('assets/js/mousetrap.min.js?v='.$cacheVer);?>"></script>
 <script src="<?=base_url('assets/js/ctrl-q-click.js?v='.$cacheVer);?>"></script>

 <script src="<?=base_url('assets/js/bootstrap.min.js?v='.$cacheVer);?>"></script>
 <script type="text/javascript" src="<?=base_url('assets/js/chosen.jquery.js?v='.$cacheVer)?>"></script>
 <script type="text/javascript" src="<?=base_url('assets/js/select2.js?v='.$cacheVer)?>"></script>
 <script type="text/javascript" src="<?=base_url('assets/js/sweetalert2.js?v='.$cacheVer)?>"></script>

 <script type="text/javascript" src="<?=base_url('assets/js/jquery-validate.js?v='.$cacheVer)?>"></script>

 <script type="text/javascript" src="<?=base_url('assets/js/vue.min.js?v='.$cacheVer)?>"></script>
 <script type="text/javascript" src="<?=base_url('assets/js/vue-select.js?v='.$cacheVer)?>"></script>
 <script type="text/javascript" src="<?=base_url('assets/js/app.js?v='.$cacheVer)?>"></script>
 <script type="text/javascript" src="<?=base_url('assets/js/vex.combined.min.js?v='.$cacheVer)?>"></script>
 <script type="text/javascript">
  function getBaseUrl(){
    return <?=json_encode(site_url())?>;
  }
 </script>
 <?php if($this->config->item('auto_logout')): ?>
   <script type="text/javascript" src="<?=base_url('assets/js/auto-logout.js?v='.$cacheVer)?>"></script>
<?php endif; ?>

 <?php if(isset($js_files)): ?>
  <?php  foreach($js_files as $js_file): 
      if(strstr($js_file,'jquery-1.11.1.min.js')){
        continue;
      }
  ?>
    <script type="text/javascript" src="<?=at($js_file).'?v='.$cacheVer?>"></script>
  <?php endforeach; ?>
<?php endif;?>
 <script type="text/javascript" src="<?=base_url('assets/js/party-name-pop-up.js?v='.$cacheVer)?>"></script>

<script type="text/javascript">
jQuery(function(){
  
  $('form.validate').each(function(){
    $(this).validate();
  })
  
  // $('.account_selector').select2('open');

  $(".chosen-select").chosen();

  $("._datepicker" ).datepicker({ 
      dateFormat: 'yy-mm-dd' 
   });
})
</script>
<!-- Hiding the domestic usertype column when export customer is added  -->
<script>
function goBack() {
    window.history.back();
}
</script>

<script type="text/javascript">
  function delete_machine(machine_id){

    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {

        
        if (result.value) {
          location.href=window.getBaseUrl()+'/machine/delete/'+machine_id;  
          // swal(
          //   'Deleted!',
          //   'Your file has been deleted.',
          //   'success'
          // )
        }
      });
  }
</script>

<div style='height:20px;'></div>  
</body>
</html>

