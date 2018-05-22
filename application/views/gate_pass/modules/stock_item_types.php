 <fieldset>
  <legend>Stock Item Types</legend>
  <div class="form-group" >
   <table class="table table-stripped">
    <tr v-for='_stockItems in _recordsSplitter(stock_item_types,5)'>
        <td width="20%" v-for='_stockItem in _stockItems'>
          <div class="splitter-title">{{_stockItem.stock_item.name}}</div>
          <div class="splitter-input">
            <input type="number" 
                   class="form-control stock_item_bags material_type"  
                   min="0" 
                   v-bind:style="validBagCountTypeStyle"
                   v-model="_stockItem.bags"
                   v-bind:name="'stock_items['+_stockItem.stock_item.id+']'">
          </div>
        </td>
     
    </tr>
   
      <tr>
       
        <!-- <td v-for='_stockItem in _recordsSplitter(stock_item_types,4)' :key="stock_item_types._hash"> 
          <div class='bold'>{{_stockItem.stock_item.name}}</div>
          <div>
            <input type="number" 
                   class="form-control stock_item_bags material_type"  
                   min="0" 
                   v-bind:style="validBagCountTypeStyle"
                   v-model="_stockItem.bags"
                   v-bind:name="'stock_items['+_stockItem.stock_item.id+']'">
          </div>
        </td>       -->
        <td class='material_type_total color_red'>
          Total :{{computedStockItemsBags}}
      
        </td>
       
      </tr>
   </table>
        <input type="text" style='height:0;width:0; border:0' 
          name="_validate_stock_items"
          data-rule-stockitems='true' />
  </div>
</fieldset>
<div class="fieldset-spacer"></div>
