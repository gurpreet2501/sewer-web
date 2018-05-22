$(function(){
  setInterval(function(){
    chrome.runtime.sendMessage(
      env('CHROME_WEIGHT_APP_ID',''),
      { data: "data to pass to the chrome app" },  
      function (response){ 
        // response = 45;
        console.log('Got response from chrome :'+response);
        // console.log('Got response from chrome :'+window.GATE_ENTRY.secondWeight);
        
        if(!window.GATE_ENTRY)
          return;

        // console.log(window.GATE_ENTRY.entry_type);
        if(window.GATE_ENTRY.entry_type == 'IN' && !window.GATE_ENTRY.secondWeight){
          window.GATE_ENTRY.setTareWeight(0);
          window.GATE_ENTRY.setLoadedWeight(response);
        }
        else if(window.GATE_ENTRY.entry_type == 'IN' && window.GATE_ENTRY.secondWeight)
          window.GATE_ENTRY.setTareWeight(response);
        else if(window.GATE_ENTRY.entry_type == 'OUT' && !window.GATE_ENTRY.secondWeight){
          window.GATE_ENTRY.setLoadedWeight(0);
          window.GATE_ENTRY.setTareWeight(response);
        }
        else if(window.GATE_ENTRY.entry_type == 'OUT' && window.GATE_ENTRY.secondWeight)
          window.GATE_ENTRY.setLoadedWeight(response);
        // alert(response)

       if(window.GATE_ENTRY.common_fields.deduct_packing_material == true)
          window.GATE_ENTRY.weightChange();
        
        
      }
    );
  },100);
});
