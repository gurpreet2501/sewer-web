<style type="text/css">
	
  
    .pull-right{
        text-align: right
    }
	.btn-success {
    color: #fff;
    background-color: #5cb85c;
    border-color: #4cae4c;
	}
	.btn {
    display: inline-block;
    padding: 6px 12px;
    margin-bottom: 0;
    font-size: 14px;
    font-weight: 400;
    line-height: 1.42857143;
    text-align: center;
    white-space: nowrap;
    vertical-align: middle;
    -ms-touch-action: manipulation;
    touch-action: manipulation;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    background-image: none;
    border: 1px solid transparent;
    border-radius: 4px;
}
</style>
<div class="pull-right">
    <a href="<?=site_url('manager_dashboard/transactions_report/?account_id='.$primary_account->id.'&from_date='.$from_date.'&to_date='.$to_date.'&pdfDownload=true')?>"><button type="button" class="btn btn-success">Download Pdf</button></a>
	<a href="<?=site_url('manager_dashboard/transactions_report/?account_id='.$primary_account->id.'&from_date='.$from_date.'&to_date='.$to_date.'&csvDownload=true')?>"><button type="button" class="btn btn-success">Download Csv</button></a>
</div>
