<fieldset> 
  <legend>Godown &amp; Labour Allocation </legend>
  <div class="form-group">
   <table class="table table-stripped">
     <tr>
       <th>Godown Name</th>
       <th>Job Done</th>
       <th>No. of Bags </th>
       <th>Labour Party Name </th>
       <th>Remarks</th>
     </tr>
     <tr>
       <td width="20%">
          <div class="dropdown">
            <select class="form-control required" name="ge_godown_labor_allocation[godown_id]" v-model="ge_godown_labor_allocation.godown_id">
              <? foreach($godowns as $godown): ?>
                <option value=<?=at($godown->id)?>>
                  <?=ht($godown->name)?>
                </option>
              <? endforeach; ?>
            </select>
          </div>
       </td>
       <td width="20%">
         <div class="dropdown">
            <select v-model="ge_godown_labor_allocation.job_status"
            name='ge_godown_labor_allocation[job_status]'
            class="form-control required" aria-labelledby="dropdownMenu1">
              <option>PENDING</option>
              <option>DONE</option>
            </select>

          </div>

       </td>

        <td width="17%">   
          <input type="number" class="form-control ge_godown_labor_allocation_bags required"  min="0"
                  name="ge_godown_labor_allocation[bags]" v-model="ge_godown_labor_allocation.bags">
        </td>
        
        <td>
          <input type="text" class="form-control required"  
                name="ge_godown_labor_allocation[labor_party_name]" v-model="ge_godown_labor_allocation.labor_party_name">
        </td>

       <td>
        <input 
            name="ge_godown_labor_allocation[remarks]"  v-model="ge_godown_labor_allocation.remarks"
            class="form-control" 
            rows="0" /></td>
     </tr>
   </table>
  </div>
</fieldset>  
<div class="fieldset-spacer"></div>
