<fieldset>
<legend>Form Type</legend>  
	<div class="radio">
	  <label v-for="_form in forms">
	  	<?php if($isUpdate):?>
	  		<input 
		    type="hidden" 
		    name="form_id"  
		    v-model="selected_form"
		    v-on:click="selectForm(_form.id)"
		    data-msg-required="Choose Stock Group."
		    class="material-choices required" 
		    v-bind:value="_form.id"
    		>	
	  	<?php endif; ?>
	    <input 
		    type="radio" 
		    name="form_id"  
		    v-model="selected_form"
		    v-on:click="selectForm(_form.id)"
		    data-msg-required="Choose Stock Group."
		    class="material-choices required" 
		    v-bind:value="_form.id"
    		v-bind:disabled="!canChangeSelection"
    		>
	      {{_form.name}}
	  </label>
	</div>
</fieldset>
<div class="fieldset-spacer"></div>
