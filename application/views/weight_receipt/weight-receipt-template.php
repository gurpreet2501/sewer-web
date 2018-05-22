<?php 
$commodity = '';
if(count($data['godown_qc_labor_allocation'])){
  $commodity = $data['godown_qc_labor_allocation'][0]['stock_items']['stock_group']['name'];
}

$itemsData = [];

  if(isset($data['godown_qc_labor_allocation'])){

    foreach ($data['godown_qc_labor_allocation'] as $key => $v) {
          if(!isset($v['stock_items']))
            continue;

      if(isset($itemsData[$v['stock_items']['name']]['bags'])){
        $itemsData[$v['stock_items']['name']]['bags'] = $itemsData[$v['stock_items']['name']]['bags'] + $v['bags'];
        continue;
      }
      
      $itemsData[$v['stock_items']['name']]['bags'] =  $v['bags'];

    }

  }


 ?>

  <h3>Weighment Slip</h3>
    <table class="table table-stripped">
      <tr>
        <td class="bold">Slip No.</td>
        <td><?=$data['id'].$data['prefix'].$data['serial']?></td>
        <td class="bold">Print Date: </td>
        <td><?=printDate(date('Y-m-d H:i:s'))?></td>
      </tr> <!-- First row -->  

      <tr>
        <td class="bold">Party Name:</td>
        <td><?=$data['account_name']?></td>
        <td class="bold">Truck No:</td>
        <td><?=$data['truck_no']?></td>
      </tr>
      <tr>
        <td class="bold">Chatni Report No:</td>
        <td><?=$data['chatni_report_no']?></td>
        <td class="bold">Gate Pass No.:</td>
        <td><?=$data['gate_pass_no']?></td>
      </tr>
      <tr>
        <td class="bold">Commodity:</td>
        <td><?=$commodity?></td>
      </tr>
    </table>  
    <div class="margin-top-5"></div>
    <table class="table table-stripped">
      <tr>
        <td class="bold">Loaded Truck Wt:</td>
        <td><?=$data['loaded_weight']?></td>
        <td colspan="2" align="center"><?=printDate($data['loaded_weight_time'])?></td>
      </tr>
      <tr>
        <td class="bold">Empty Truck Wt:</td>
        <td><?=$data['tare_weight']?></td>
        <td colspan="2" align="center"><?=printDate($data['tare_weight_time'])?></td>
      </tr>
      <tr>
        <td class="bold">Gross Weight:</td>
        <td><?=$data['gross_weight']?></td>
      </tr>
      <tr>
        <td class="bold">Empty Gunny Wt.:</td>
        <td><?=($data['deduct_packing_material']) ? $data['packing_material_weight'] : 0?></td>
      </tr>  
      <tr>
        <td class="bold">Net Wt.:</td>
        <td><?=$data['net_weight']?></td>
      </tr>  
    </table>
    <div class="margin-top-5"></div>  
     <table class="table table-bordered">  
      <tr>
        <?php foreach ($itemsData as $key => $ge): ?>
          <td class="bold" align='center'><?=$key?></td>
        <?php endforeach ?>
        <td class="bold" align='center'>Total</td>
      </tr>
      <tr>
        <?php $total = 0; foreach ($itemsData as $key => $ge): 
        $total = $total + $ge['bags'];?>
          <td align='center'><?=$ge['bags']?></td>
        <?php endforeach ?>
        <td align='center'><?=$total?></td>
      </tr>
    </table>
    <div class="margin-top-5"></div>  
    <table class="table table-stripped">  
       <tr>
        <?php  foreach ($data['bag_types'] as $key => $ge): 
          if(!isset($ge['stock_item']))
            continue;
        ?>
          <td class="bold"><?=$ge['stock_item']['name']?></td>
        <?php endforeach ?>
        <td class="bold">Total</td>
      </tr>
      <tr>
        <?php $total = 0; foreach ($data['bag_types'] as $key => $ge):
          if(!isset($ge['stock_item']))
            continue;
         $total = $total + $ge['bags'];?>
          <td align='center'><?=$ge['bags']?></td>
        <?php endforeach ?>
        <td align='center'><?=$total?></td>
      </tr>
    </table>
    <div class="margin-top-5"></div>
      <?php
       /* foreach ($data['quality_cuts'] as $key => $qc): ?>
        <div>
          <?php
            if($qc['bags'] > 0)
              echo $qc['quality_cut_type']['name'].':'.$qc['bags'].' x '.$qc['qty_per_bag'].' = '. $qc['bags'] * $qc['qty_per_bag'].' Kgs';?>
        </div>
        
      <?php endforeach; */?>
  
