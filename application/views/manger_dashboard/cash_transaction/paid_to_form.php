<fieldset> 
  <legend>Credit / Payment Transactions</legend>
   <div class="form-group">
   <table class="table table-stripped">
     <tr>
       <th>Account</th>
       <th>Amount</th>
       <th>Remarks</th>
       <th>Date</th>
       <th></th>
     </tr>
     <tr  v-for='(item, index) in filterTransactionsPayment()' :key="item.hash">
       <td width="40%">
         <div class="dropdown">   
          
            <select2 class="form-control" v-bind:name="'paid[items]['+ index + '][secondary_account_id]'" v-model="item.primary_account_id"
              :options="getAccounts()" 
              text="name" 
              id="id"
              >
              <option disabled value="0">Select Account</option>
            </select2>
          </div>
      
       </td>
       <input type="hidden" class="form-control" 
          v-bind:value="item.id" 
          v-bind:name="'paid[items]['+ index + '][id]'">
       <td><input type="text" class="form-control paid-amount" 
          v-model="item.amount" 
          min="0" 
          v-bind:name="'paid[items]['+ index + '][amount]'"></td>

       <td><input type="text" v-tooltip
          v-bind:name="'paid[items]['+ index + '][remarks]'"   v-bind:title="item.remarks" v-model="item.remarks"
          v-bind:value="item.remarks" class="form-control"></td>
       <td>
        <datepicker 
          class="form-control required transaction_date" 
          v-bind:name="'paid[items]['+ index + '][transaction_date]'"
          v-model="item.transaction_date" v-bind:style="transactionDateStyle(item.date_valid)"
        />
       </td>
       <td> <span class="glyphicon glyphicon-trash " id="delete_row" 
          v-on:click="removeTransaction(item.hash)" aria-hidden="true"></span></td>
       <input type="hidden" 
          v-bind:name="'paid[items]['+ index + '][entry_type]'" value="CASH">
       <input type="hidden" 
          v-bind:name="'paid[items]['+ index + '][transaction_type]'" value="DEBIT">
      </tr>
      <br/>
   </table>
  </div> <!-- div ends -->
   <div class="row pull-right">
    <div class="col-xs-12 ">
      <span class="glyphicon glyphicon-plus" id="add_row" aria-hidden="true" 
          v-on:click="insertEmptyTransaction(0,primary_account)"></span>
    </div>
  </div>
</fieldset>  
<div class="fieldset-spacer"></div>
