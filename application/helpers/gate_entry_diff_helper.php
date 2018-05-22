<?php  

function getStockItemName($id){
 $si = Models\StockItems::where('id', $id)->first();
 return isset($si->name) ? $si->name : '';
}

function getLaborJobTypes($id){
 $lb = Models\LabourJobTypes::where('id', $id)->first();
 return isset($lb->name) ? $lb->name : '';
}


