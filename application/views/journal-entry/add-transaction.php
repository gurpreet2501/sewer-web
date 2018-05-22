<?php $this->load->view('admin/partials/header');  ?>
<?php $this->load->view('journal-entry/date-filter'); ?>
<div class="container">
  <div class="row">
    <div class="col-xs-12">
        <div id="journal-transaction"> 
          <form method="post" action="<?=site_url('journal_entry/addTransactionPost')?>">
            <h2 class="text-center">Journal Entries</h2>
             <div class="form-group" >
               <table class="table table-stripped">
                 <tr>
                  <th>#</th>
                   <th width="9%">Date</th>
                   <th >Recieved From</th>
                   <th>Paid To</th>
                   <th>Amount</th>
                   <th>Remarks</th>
                   <th></th>
                 </tr>
                 <tr v-for='(item, index) in transactions' :key="item.hash" v-bind:id="index">
                  <td colspan="7">
                    <table cellpadding="0px" cellspacing="4px" style="width: 100%;"  id="journal-entry-tbl">
                      <tr>
                        <td width="6%"> 
                          <span v-if="item.id">
                            #{{ item.id }}                
                          </span>
                        </td>
                         <td class='date' width="11%">
                            <datepicker 
                              class="form-control required mousetrap" 
                              v-bind:name="'trx['+ item.hash + '][transaction_date]'"
                              v-bind:style="transactionDateStyle(item.date_valid)"
                              v-model="item.transaction_date"
                            />
                          </td>
                        <td>
                          <input type="hidden" class="mousetrap" :name="'trx['+ item.hash + '][id]'" v-bind:value="item.id" />
                          <agdropdown class="mousetrap cash_transaction_forms"  next_field_id="" v-bind:hidden_field_name="'trx['+ item.hash + '][primary_account_id]'"  v-bind:options="accounts" v-model="item.primary_account_id" > 
                            </agdropdown>
                         </td>
                        <td>
                          <agdropdown class="mousetrap cash_transaction_forms"  next_field_id="" v-bind:hidden_field_name="'trx['+ item.hash + '][secondary_account_id]'"  v-bind:options="accounts" v-model="item.secondary_account_id" > 
                            </agdropdown>
                         </td>



                          <td width="8%">
                                   <input type="text" class="form-control mousetrap received-items debit_amount" 
                              v-model="item.amount" v-bind:name="'trx['+ item.hash + '][amount]'"></td>

                          <input type="hidden" class="form-control mousetrap" 
                              v-bind:value="item.id" 
                              v-bind:name="'trx['+ item.hash + '][id]'">
                          
                          </td>
                          <td>
                            <input type="text" class="mousetrap form-control" placeholder="Remarks" 
                                    v-tooltip
                                    v-bind:value="item.remarks"   
                                    v-bind:title="item.remarks" 
                                    v-model="item.remarks"
                                    v-bind:name="'trx['+ item.hash + '][remarks]'"  class="form-control _tooltip" rows="1"></input>
                          <td>
                          <td>
                            <span class="glyphicon glyphicon-trash mousetrap" id="delete_row" 
                              v-on:click="removeTransaction(item.hash)" aria-hidden="true"></span></td>
                            <input type="hidden" 
                              v-bind:name="'trx['+ item.hash + '][entry_type]'" class="mousetrap" value="CASH">
                            <input type="hidden" value="<?=$from_date?>" name="from_date">
                            <input type="hidden" value="<?=$to_date?>" name="to_date">
                          </td>
                      </tr>
                    </table>
                    </td> 
                  </tr>
               </table>
            </div> <!-- div ends -->
             <div class="row pull-right">
              <div class="col-xs-12 ">
              <span class="shortcut">(ctrl+y)</span>
                <span class="glyphicon glyphicon-plus ctrl_y_click" aria-hidden="true"
                 data-ctr_y_area_selector="#debit_trans"
                 id="add_row" aria-hidden="true" 
                    v-on:click="insertEmptyTransaction()"></span>
              </div>
            </div>
            <br>
            <div class="text-center">
              <input type="submit" class="btn btn-danger text-center center-wide-btn" value="Save"/>
            </div>
          </form>
              <!-- row -->
          </div> 
    </div>
  </div>
</div>
 
<div class="fieldset-spacer"></div>
<?php $this->load->view('admin/partials/footer');  ?>

