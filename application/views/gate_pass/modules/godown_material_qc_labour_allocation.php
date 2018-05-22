<fieldset> 

  <legend> Material Godown Labour Allocation </legend>
   <div class="form-group">

   <table class="table table-stripped">
     <tr>
       <th>Item</th>
       <th>No. of Bags</th>
       <th>Godowns</th>
       <th>Labour Party</th>
       <th>Job Done</th>
       <th>Remarks</th>
     </tr>
     <tr id="generate_duplicate" v-for='allocation in godown_material_qc_labour_allocation' :key="allocation._hash">
       <td  width="16%">
        <!-- Items -->
          <div class="dropdown" >
             <div class="dropdown">
                <select 
                  class="mousetrap form-control required" 
                  v-bind:name="'ge_godown_qc_labor_allocation['+allocation._hash+'][stock_item_id]'" 
                  aria-labelledby="dropdownMenu1"  
                  v-model="allocation.stock_item_id"
                  >         
                  <option v-for="_stock_item in moduleFlatStockItems('godown_material_qc_labour_allocation')"  v-bind:value="_stock_item.id"> {{_stock_item.name}} </option>
              </select>
            </div>
          </div>
       </td>

        <td  width="13%"> 
        <!-- no of bags -->
          <input 
            type="number" class="mousetrap form-control required ge_god_qc_mat_bags"  
            v-model="allocation.bags" 
            min="0"
            v-bind:style="validBagCountTypeStyle"
            v-bind:name="'ge_godown_qc_labor_allocation['+allocation._hash+'][bags]'">

        </td>
       <td  width="16%">
        <!-- godowns -->
           <div class="dropdown">
               <select class="mousetrap form-control required" 
                  v-model="allocation.godown_id"
                  v-bind:name="'ge_godown_qc_labor_allocation['+allocation._hash+'][godown_id]'">
              <? foreach($godowns as $godown): ?>
                <option value=<?=at($godown->id)?>>
                  <?=ht($godown->name)?>
                </option>
              <? endforeach; ?>
            </select>
            </div>
       </td>
       <td  width="16%">
          <!-- Labour Party  -->
           <div class="dropdown">
               <select 
                class="mousetrap form-control required" 
                v-model="allocation.labour_party_id"
               v-bind:name="'ge_godown_qc_labor_allocation['+allocation._hash+'][labour_party_id]'" 
                >
                <option 
                v-for="party in selectLaborParty('godown_material_qc_labour_allocation')"
                v-bind:value="party.id" :key="party.id">
                  {{party.name}}
                </option>
            </select>
            </div>
       </td>
       <td  width="16%">
          <!-- job done  -->
           <div class="dropdown">
               <select 
                 v-bind:name="'ge_godown_qc_labor_allocation['+allocation._hash+'][labour_job_type_id]'"
                v-model="allocation.labour_job_type_id"
                     class="mousetrap form-control required">
                    <option 
                    v-for="_jobType in selectLaborJobtype('godown_material_qc_labour_allocation')"
                    v-bind:value="_jobType.id" 
                    >
                      {{_jobType.name}}
                    </option>
                  </select>
              </select>
            </div>
       </td>
 
       <td>
        <input  
            v-bind:name="'ge_godown_qc_labor_allocation['+allocation._hash+'][remarks]'"
            class="form-control mousetrap" 
            v-model="allocation.remarks"
            rows="0" />
        </td>
        <td> <span class="glyphicon glyphicon-trash" id="delete_row" v-on:click="removeGodownAllocation(allocation)" aria-hidden="true"></span></td>
      </tr>
      <tr>
        <td></td>
        <td>
          <span class="color-red">Bags : {{bagsTotalMaterialGodAlloc}}</span>
        </td>
       </tr> 
   </table>
  </div> <!-- div ends -->
   <div class="row pull-right">
    <div class="col-xs-12 ">
      <span class="shortcut">(ctrl+y)</span> <span 
        class="glyphicon glyphicon-plus ctrl_y_click"
        data-ctr_y_area_selector="#godown_material_qc_labour_allocation"
        id="add_row" 
        aria-hidden="true" 
        v-on:click="addGodownAllocation()"
        ></span>
    </div>
  </div>
</fieldset>  
<div class="fieldset-spacer"></div>

