<?php $this->load->view('admin/partials/header');
$form_url = site_url('gate_pass/save');
if(isset($autofill['id']))
  $form_url = site_url('gate_pass/save/'.$autofill['id']); 

?>
<!-- Dont Change form id. Some css rules are based on this id in sb-admin.css -->
<form method="POST" 
      action="<?=$form_url?>" 
         id="gate-entry"
      class="gate-entry-form">
<!-- Custom menu  -->
<!-- Set hidden_field_name for hidden input id box -->
<!--  <agdropdown name="party_name" hidden_field_name="party_id" v-bind:options="common_fields.accounts" v-model="common_fields.account_id"> 
</agdropdown> -->
<!-- Custom menu  -->

  <div class="row">
    <div class="col-lg-12 text-center">
      <input type="hidden" name="editable_field" value="<?=$only_edit?>" />
      <input type="hidden" name="redirect_url" value="<?=htmlentities($redirect_url)?>" />
      <?php $this->load->view('choice/material-in-out-choice'); ?>
    </div>
  </div>
  
  <div class="alert alert-danger" v-if="!validBagsCount">
    Number of bags are not matching.
  </div>

  <div class="alert alert-danger" v-if="!validQCBagsCount">
    Number of bags in Quality cut are greater than bags in Godown and labour allocation.
  </div>
 
  <div class="row">
    <div class="col-lg-4">
      <div id="stock-groups" v-if="entry_type">
        <?php $this->load->view('gate_pass/modules/forms'); ?>
      </div>
      
      <div id="common-fields" v-if="selected_form">
        <?php $this->load->view('gate_pass/modules/common-fields', []);?>
      </div>    
    </div>                 
                                           
    <div class="col-lg-8">
        <div id="godown_material_qc_labour_allocation" v-if="moduleDisplay('godown_material_qc_labour_allocation')"
         class='ge__module'>
          <?php $this->load->view('gate_pass/modules/godown_material_qc_labour_allocation'); ?>
        </div>

        <div id="stock_item_types"  class='ge__module' v-if="moduleDisplay('stock_item_types')">
          <?php $this->load->view('gate_pass/modules/stock_item_types'); ?>
        </div>

        <div id="bag_type" class='ge__module' v-if="moduleDisplay('bag_types')">
          <?php $this->load->view('gate_pass/modules/bag_types', [
            
          ]); ?>
        </div>
        <div id="quality_cut" class='ge__module' v-if="moduleDisplay('quality_cut')">
        <?php $this->load->view('gate_pass/modules/quality_cut', [
            
        ]); ?>
        </div>
        <div id="godown_and_labour_allocation" class='ge__module' v-if="moduleDisplay('godown_and_labour_allocation')"> 
          <?php $this->load->view('gate_pass/modules/godown_and_labour_allocation',[
              
          ]); ?>
        </div>
      
        <div id="cmr_details" v-if="moduleDisplay('cmr_details')"
         class='ge__module'>
          <?php $this->load->view('gate_pass/modules/cmr_details'); ?>
        </div>

        <div id="cmr_rice_delivery_details" v-if="moduleDisplay('cmr_rice_delivery_details')"
         class='ge__module'>
          <?php $this->load->view('gate_pass/modules/cmr_rice_delivery_details'); ?>
        </div>

        <div class="pull-right" id="submit-btn">
          <button v-if="selected_form"
            type="button" 
            v-on:click="submitData()"
            class="submit-entry btn btn-danger"><?=$only_edit ? 'Update' : 'Submit'?></button>
        </div>
    </div>
  </div>

</form>

<?php $this->load->view('admin/partials/footer') ?>
