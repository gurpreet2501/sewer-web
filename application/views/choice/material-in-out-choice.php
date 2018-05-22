<div class="radio">
  <label>
    <?php if($isUpdate):?>
     <input 
        type="hidden" 
        name="entry_type" 
        class="material-filters required"  
        data-msg-required="Choose Appropriate Material Type" 
        v-on:click="selectEntryType('IN')" 
        id="materialIN" 
        value="IN" 
        v-model="entry_type"
        >     
    <?php endif; ?>
    <input 
    	type="radio" 
    	name="entry_type" 
    	class="material-filters required"  
    	data-msg-required="Choose Appropriate Material Type" 
    	v-on:click="selectEntryType('IN')" 
    	id="materialIN" 
    	value="IN" 
    	v-model="entry_type"
    	v-bind:disabled="!canChangeSelection">
    Material In
  </label>
  <label>
      <?php if($isUpdate):?>
    <input 
        type="hidden" 
        name="entry_type" 
        class="material-filters required" 
        v-model="entry_type" 
        v-on:click="selectEntryType('OUT')"  
        id="materialOUT" 
        value="OUT"
        >
    <?php endif; ?>
    <input 
    	type="radio" 
    	name="entry_type" 
    	class="material-filters required" 
    	v-model="entry_type" 
    	v-on:click="selectEntryType('OUT')"  
    	id="materialOUT" 
    	value="OUT"
    	v-bind:disabled="!canChangeSelection">
    Material Out
  </label>

  <div class="alert alert-danger error-container" style="display: none;margin: 15px 0px;padding:8px;"></div>
  
</div>

