function openPopUp(){
    return vex.dialog.open({
      message: 'Enter Account Name:', showCloseButton: true,
         className: 'vex-theme-os',
      input: [
          '<div class="form-group">',
            '<input name="account_name" type="text" placeholder="Enter Account Name" required />',
          '</div>',
          '<div class="form-group">',
            '<select name="account_group" placeholder="Enter Account Name" required class="form-control">',
            '<option disabled>-Select Account Group-</option>',
            '<option value="SundryCreditors">Sundri Creditors</option>',
            '<option value="SundryDebtors">Sundry Debtors</option>',
            '</select>',
          '</div>',
      ].join(''),
      buttons: [
          jQuery.extend({}, vex.dialog.buttons.YES, { text: 'Add' }),
          jQuery.extend({}, vex.dialog.buttons.NO, { text: 'Back' })
      ],
      callback: function (data) {
          if (!data) {
              console.log('Cancelled')
          } else {

              $.ajax({
                method: "POST",
                url: getBaseUrl()+'/api/accounts/add',
                data: { name: data.account_name, accounts_group:data.account_group}
              })
                .done(function( msg ) {
                  var data = JSON.parse(msg);
                  
                  if(data.STATUS == "SUCCESS"){
                    window.GATE_ENTRY.common_fields.accounts.push(data.RESPONSE);
                    window.GATE_ENTRY.$nextTick(function(){
                      window.GATE_ENTRY.common_fields.account_id = data.RESPONSE.id;
                    });
                    window.GATE_ENTRY.$forceUpdate();
                 }

              });
          }
      } //callback
  });   

}

function addCashAccount(){
    return vex.dialog.open({
      message: 'Enter Account Name:', showCloseButton: true,
         className: 'vex-theme-os',
      input: [
            '<div id="cashAccount">',
              '<div class="form-group">',
                '<input name="account_name" type="text" placeholder="Enter Account Name" required />',
                '<input name="primary_account_id" v-model="primary_account_id" type="hidden" placeholder="Enter Account Name" required />',
              '</div>',
              '<div class="form-group">',
                '<select2 class="form-control" name="account_group" :options="groups"  text="name"',
                'id="id">',
                '<option disabled value="0">Select Group</option>',
                '</select2>',
              '</div>',
            '</div>',
      ].join(''),
      buttons: [
          jQuery.extend({}, vex.dialog.buttons.YES, { text: 'Add' }),
          jQuery.extend({}, vex.dialog.buttons.NO, { text: 'Back' })
      ],
      afterOpen :function(){
        new Vue({
          el: '#cashAccount',
          data: {
                  groups: v('account_groups'),
                  primary_account_id: v('primary_account_id'),
               }
             });
      },
      callback: function (data) {
          if (!data) {
              console.log('Cancelled')
          } else {

              $.ajax({
                method: "POST",
                url: getBaseUrl()+'/api/accounts/addCashTransactionAccount',
                data: { name: data.account_name, account_group:data.account_group,primary_account_id:data.primary_account_id}
              })
                .done(function( msg ) {
                  var msg = JSON.parse(msg);
                   
                  window.CASH_TRANSACTIONS.accounts.push(msg.RESPONSE);
                 
              }); //.done
          } //else
      } //callback
  });   

}


function addAccInCrudScreen(){
    return vex.dialog.open({
      message: 'Enter Account Name:', showCloseButton: true,
         className: 'vex-theme-os',
      input: [
            '<div id="cashAccount">',
              '<div class="form-group">',
                '<input name="account_name" type="text" placeholder="Enter Account Name" required />',
              '</div>',
              '<div class="form-group">',
                '<select2 class="form-control" name="account_group" :options="groups"  text="name"',
                'id="id">',
                '<option disabled value="0">Select Group</option>',
                '</select2>',
              '</div>',
            '</div>',
      ].join(''),
      buttons: [
          jQuery.extend({}, vex.dialog.buttons.YES, { text: 'Add' }),
          jQuery.extend({}, vex.dialog.buttons.NO, { text: 'Back' })
      ],
      afterOpen :function(){

        new Vue({
          el: '#cashAccount',
          data: {
                  groups: v('account_groups'),
               }
             });
      },
      callback: function (data) {
          if (!data) {
              console.log('Cancelled')
          } else {

              $.ajax({
                method: "POST",
                url: getBaseUrl()+'/api/accounts/addCashTransactionAccount',
                data: { name: data.account_name, account_group:data.account_group}
              })
                .done(function( msg ) {
                  var msg = JSON.parse(msg);
                  window.CRUD_ACCOUNT_DROPDOWN.accounts.push(msg.RESPONSE);
                 
              }); //.done
          } //else
      } //callback
  });   

}

function addMarketNameInCmrDetails(){
    return vex.dialog.open({
      message: 'Enter Market Name:', showCloseButton: true,
         className: 'vex-theme-os',
      input: [
            '<div id="addMarket">',
              '<div class="form-group">',
                '<input name="name" type="text" placeholder="Enter Market Name" required />',
              '</div>',
              '<div class="form-group">',
                '<select2 class="form-control" name="cmr_society_id" :options="societies"  text="name"',
                'id="id">',
                '<option value="0">Select Cmr Society</option>',
                '</select2>',
              '</div>',
            '</div>',
      ].join(''),
      buttons: [
          jQuery.extend({}, vex.dialog.buttons.YES, { text: 'Add' }),
          jQuery.extend({}, vex.dialog.buttons.NO, { text: 'Back' })
      ],
      afterOpen :function(){

        new Vue({
          el: '#addMarket',
          data: {
                  societies: v('cmr_societies'),
               }
             });
      },
      callback: function (data) {
          if (!data) {
              console.log('Cancelled')
          } else {

              $.ajax({
                method: "POST",
                url: getBaseUrl()+'/api/accounts/addMarketNameInCmrForm',
                data: { name: data.name, cmr_society_id:data.cmr_society_id}
              })
                .done(function( msg ) {
                  var msg = JSON.parse(msg);
                  window.GATE_ENTRY.cmr_slip_details.markets.push(msg.RESPONSE);
                    window.GATE_ENTRY.$nextTick(function(){
                      window.GATE_ENTRY.cmr_details.cmr_market_id = msg.RESPONSE.id;
                    });
                  window.GATE_ENTRY.$forceUpdate();
                 
              }); //.done
          } //else
      } //callback
  });   

}

function cancelGateEntry(){

    return swal(" something:", {
    content: "input",
    html: true,
  })
  .then((value) => {
    if(value == false)
       console.log(false);
    else
       console.log(true);
     $ = jQuery;
     $('.cancel-ge-btn').click(function(){
      alert('sss')
     })

  })
}
