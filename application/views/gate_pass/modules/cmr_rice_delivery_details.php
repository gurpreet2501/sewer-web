<fieldset class="cmr-rice-details">

<legend>CMR Rice Delievery Details</legend>

   <div class="form-group form-inline">

    <label for="exampleInputPassword1">CMR Agency Account</label>

    <select class="form-control required"  v-model="cmr_rice_delivery_details.cmr_agency_id"
    name="cmr_rice_delivery_details[cmr_agency_id]">
       <? foreach($cmr_agencies as $cmr_agency): ?>
          <option value=<?=at($cmr_agency->id)?>>
            <?=ht($cmr_agency->name)?>
          </option>
        <? endforeach; ?>
    </select>
  </div>  

  <div class="form-group form-inline">
    <label for="exampleInputPassword1">Delievery To</label>
    <select class="form-control required"  v-model="cmr_rice_delivery_details.delivery_to_id"
    name="cmr_rice_delivery_details[delivery_to_id]">
       <? foreach($delivery_destinations as $delivery_destination): ?>
          <option value=<?=at($delivery_destination->id)?>>
            <?=ht($delivery_destination->name)?>
          </option>
        <? endforeach; ?>
    </select>
  </div>

  <div class="form-group form-inline">
    <label for="exampleInputPassword1">FCI Godown Name</label>
    <select class="form-control required"
      name="cmr_rice_delivery_details[fci_godown_id]" v-model="cmr_rice_delivery_details.fci_godown_id">
      <? foreach($fci_godowns as $fci_godown): ?>
          <option value=<?=at($fci_godown->id)?>>
            <?=ht($fci_godown->name)?>
          </option>
        <? endforeach; ?>
    </select>
  </div> 

  <div class="form-group form-inline">
    <label for="exampleInputPassword1">Lot No</label>
    <input type="text" class="form-control required" v-model="cmr_rice_delivery_details.lot_num" id="exampleInputPassword1" placeholder="Enter Lot No."
      name="cmr_rice_delivery_details[lot_num]">
  </div> 

</fieldset>

<div class="fieldset-spacer"></div>

