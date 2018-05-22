<? $this->load->view('admin/partials/header') ?>
<div id="cmr-details">
<form action="<?=site_url('cmr_details/cmr_post')?>" method="post" class="validate">
    <fieldset class="cmr-details">
      <legend>Add CMR Slip Details</legend>
      <div class="row">
        <div class="col-md-6">

          <div class="form-group form-inline">
            <label>Agency</label>
            <agdropdown 
              name="cmr_agency_name" 
              input_class='required' 
              hidden_field_name="cmr_details[cmr_agency_id]" 
              v-bind:options="cmr_agencies" 
              v-model="cmr_agency_id" 
              next_field_id="m_serial_no" 
              tabindex="1"> 
            </agdropdown> 
        </div>   

          <!-- //Account name -->
          <div class="form-group form-inline">
            <label for="exampleInputEmail1">Account Name</label>
            <agdropdown name="cmr_account_name" input_class='required' next_field_id="truckNo" hidden_field_name="cmr_details[account_id]" v-bind:options="accounts" v-model="account_id" tabindex="3"> 
            </agdropdown> 

          </div>      

          <!-- Market Name -->
           <div class="form-group form-inline">

            <label for="cmr_agency">Market Name</label>
              
             <agdropdown next_field_id="society_name" input_class='required' v-on:change="getSocietyDetail" hidden_field_name="cmr_details[cmr_market_id]" v-bind:options="markets" v-model="cmr_market_id" tabindex="5"> 
            </agdropdown> 

            <div class="glyphicon glyphicon-plus add-pop-up" onclick="addMarketNameInCmrDetails()"></div>

        </div> <!-- form-group --> 

        <!-- Tp no   -->
        <div class="form-group form-inline">
          <label for="tp_no">TP No</label>
          <input type="text" class="form-control required" id="tp_no" placeholder="Enter TP No"
          name="cmr_details[tp_no]"
          v-model="tp_no" tabindex="7">
        </div> 

        <!-- //Ac Note no  -->
         <div class="form-group form-inline">
            <label for="ac_note_no">AC Note No</label>
            <input type="text" class="form-control" id="ac_note_no" placeholder="Enter AC Note No"
            name="cmr_details[ac_note_no]"
            v-model="ac_note_no" tabindex="9">
         </div>

        <div class="form-group form-inline">
            <label for="quintals">Quintals</label>
            <input type="text" class="form-control required"  id="quintals"
            name="cmr_details[quintals]"
            v-model="quintals" min=".001" tabindex="11">
        </div> 



        <!-- //M serial no -->


        </div> <!-- col-md-6 -->

        <div class="col-md-6">

          <div class="form-group form-inline">
            <label for="remarks">M.Serial No.</label>
            <input type="text" class="form-control required"
            name="cmr_details[m_serial_no]"
            v-model="m_serial_no" tabindex="2" id="m_serial_no">
          </div> 

      <div class="form-group form-inline">
        <label for="truckNo">Truck No: </label>
        <input 
        type="text" 
        v-on:keyup="upper()" 
        class="form-control required" 
        id="truckNo" 
        placeholder="Enter Truck No"
        name="cmr_details[truck_no]"
        v-model="truck_no"
        v-bind:value="truck_no" tabindex="4">
      </div>  

 


      <div class="form-group form-inline">
        <label for="tp_date">Society Name</label>
        <select class="form-control required" name="cmr_details[cmr_society_id]" tabindex="6" id="society_name">
        <option  v-for="society in getSocietyDetail()" v-bind:value="society.id">{{society.name}}</option>
        <option v-for="society in getSocietyDetail()" v-bind:value="society.id">{{society.name}}</option>
        </select>
      </div>  

      <div class="form-group form-inline">
        <label for="tp_date">TP Date</label>
        <datepicker 
          class="form-control required" 
          name="cmr_details[tp_date]"
          v-model="tp_date" tabnext="ac_note_no" id="tp_date"
          tabindex="8"
        />
      </div>  

      <div class="form-group form-inline">
        <label for="ac_note_date">AC Note Date</label>
          <datepicker 
            class="form-control" 
            name="cmr_details[ac_note_date]"
            v-model="ac_note_date" tabnext="quintals" id="ac_note_date"
            tabindex="10"
          />
      </div>  

        <div class="form-group form-inline">
          <label for="no_of_bags">No of bags</label>
          <input type="text" class="form-control required" id="no_of_bags" min='1' placeholder="No of bags"
          name="cmr_details[no_of_bags]"
          v-model="no_of_bags" tabindex="12">
        </div> 
 

        </div> <!-- col-md-6 -->

      </div> <!-- row -->

    </fieldset>
    <br>
    <div class="pull-right">
      <input type="submit" value="Submit" class="btn btn-danger submit-btn"  tabindex="13" />
      <a href="<?= site_url('data/cmrDetails') ?>" class="btn btn-default" >Cancel</a>

    <div class="fieldset-spacer"></div>  
    </div>
    
  </form>
  </div>

<? $this->load->view('admin/partials/footer') ?>
