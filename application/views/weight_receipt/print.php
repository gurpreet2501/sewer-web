<html>
<head>
<style>
.divh {
    font-family: Arial, Helvetica, sans-serif;
    font-size: 17px;
}

/* page css*/

@page {
    /* dimensions for the whole page */
    size: A5;
    
    margin: 0;
}

html {
    /* off-white, so body edge is visible in browser */
    background: #eee;
}

body {
    /* A5 dimensions */
    height: 210mm;
    width: 148.5mm;

    margin: 0;
}

/* fill half the height with each face */
.face {
    height: 50%;
    width: 100%;
    position: relative;
}

/* the back face */
.face-back {
    background: #f6f6f6;
}

/* the front face */
.face-front {
    background: #fff;
}

/* an image that fills the whole of the front face */
.face-front img {
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    width: 100%;
    height: 100%;
}
/* page css*/

.divr {
    width: 100%;
    clear: left;
}

.divc {
    float: left;
    width: 300px;
    height: 20px;
    margin: 5px;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 15px;
}
.back-button{
  background: #D43F3A;
  color:#fff;
  padding:4px;
  height: 15px
  border-radius:4px;
  border:1px solid transparent;
  min-width: 50px
}
.outer-box {
    margin-left: 24px;
    margin-top: 31px;
}
table {
    border-collapse: collapse;
    padding: 13px
}
table td{
  padding: 5px
}

table, td, th {
    border: 1px solid #ccc;
}

tr td:nth-child(1), tr td:nth-child(3) {
    /*font-weight: bold;*/
}
.text-center{
  text-align: center !important;
}

.margin-top-5{
  margin-top:5px;
}
.bold{
  font-weight: bold;
}
@page { size: auto;  margin: 0mm; padding: 10mm;}
@media print { 
/* All your print styles go here */
 html, body {
        height: auto;    
    }
 .back-button { display: none} 
}
</style>
</head>
<body style="overflow:hidden; margin:0" onload="window.print()">
  <div class="outer-box">
<?php
 

 $item_group = 
        isset($data['godown_qc_labor_allocation'][0]['stock_items']['stock_group']['name']) ?
          $data['godown_qc_labor_allocation'][0]['stock_items']['stock_group']['name'] :
          '';
         ?>
      <a href="<?=$redirect_url?>"><button class="back-button">Back</button></a>       
  <?php $this->load->view('weight_receipt/weight-receipt-template'); ?>
  <br>
  

<br/>
 
  
</div>
</body>
</html>
