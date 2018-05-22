 <fieldset> 
  <legend>Material Out Item Choice</legend>
  <div class="radio">
    <?php foreach($choices as $key => $choice): ?>
   <label>
    <input type="radio" name="material_out_stock_group" class="material-choices" id="<?=strtolower($choice->id)?>" value="<?=at($choice->id)?>">
    <?=$choice->name?>
    </label>
  <?php endforeach; ?>  
  </div>

</fieldset>  
<div class="fieldset-spacer"></div>
