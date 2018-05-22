 <fieldset> 

  <legend>Quality Cut</legend>

  <div class="form-group">

  <table class="table table-stripped">
     <tr>
       <th>Select</th>
       <th>No of Bags</th>
       <th>Qc Quantity(per Bag)</th>
       <th width="10%">Total</th>
       <th>Remarks</th>
     </tr>
     <tr v-for='qc in quality_cut' :key="qc._hash">
       <td width="20%">
          <div class="dropdown">
            <select class="mousetrap form-control quality_cut_dd" 
              v-bind:name="'quality_cut['+qc._hash+'][quality_cut_type]'" 
              v-model="qc.quality_cut_type"
              aria-labelledby="dropdownMenu1">              
                <option 
                  v-for="_qualityCutTypes in 
                         moduleQCTypes('quality_cut')"  
                  v-bind:value="_qualityCutTypes.id"> 
                  {{_qualityCutTypes.name}} 
                </option>
            </select>
          </div>
       </td>
       
       <td>
        <input 
          type="text" 
          class="mousetrap form-control quality_cut" 
          id="qc_no_of_bags" 
          v-bind:style="validQcBagsCountStyle"
          v-bind:name="'quality_cut['+qc._hash+'][bags]'"
          v-model="qc.bags"
       
          >
        </td>

       <td>
        <input 
          type="number" 
          class="mousetrap form-control quality_cut" 
          id="qc_quantity" 
          v-bind:name="'quality_cut['+qc._hash+'][qty_per_bag]'" 
          v-model="qc.qty_per_bag"
          min="0" >
        </td>

       <td>
        <div id="qc_total" class="color_red qc_total">{{ selectQualityCutTotal(qc) }}</div>
       </td>

       <td>
          <input 
            class="mousetrap form-control" 
            v-bind:name="'quality_cut['+qc._hash+'][remarks]'"
            v-model='qc.remarks'
            rows="0" />
       </td>

       <td> 
          <span 
            class="glyphicon glyphicon-trash" 
            id="delete_row" 
            v-on:click="removeQCCut(qc)" 
            aria-hidden="true"></span>
       </td>
     </tr>
   </table>

  </div>
  <div class="row pull-right">
    <div class="col-xs-12 ">
     <span class="shortcut">(ctrl+y)</span> <span 
      class="glyphicon glyphicon-plus ctrl_y_click" 
      data-ctr_y_area_selector="#quality_cut" 
      id="add_row" aria-hidden="true" v-on:click="addQCCut()"></span>
    </div>
  </div>
</fieldset>  
<input class="show_qc_errors" type="text" style="height: 0px;display: block;width:0px;border:none" />
<div class="fieldset-spacer"></div>
