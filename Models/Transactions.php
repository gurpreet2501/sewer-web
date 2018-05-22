<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Capsule\Manager as DB;

class Transactions extends Model
{
    protected $table    = 'transactions';
    protected $fillable = ['entry_type',  'primary_account_id', 'amount','remarks','secondary_account_id','transaction_date'];



    public static function balanceTill($date ,$accountId)
    {   
        $total = 0;
        $date = $date.' 23:59:59';

        $credit = self::creditUntil($date ,$accountId);
       
        $debit = self::debitUntil($date ,$accountId);
   
        $total = $credit - $debit;

        return round($total,2);
    }

    public static function creditBetween($from, $to, $accountId){
        $amount = self::where('secondary_account_id', $accountId)
                         ->between($from, $to)
                         ->sum('amount');
        return round($amount,2);
    }

    public static function debitBetween($from, $to, $accountId){
        $amount = self::where('primary_account_id', $accountId)
                        ->between($from, $to)
                        ->sum('amount');
        return round($amount,2);
    }

    public static function creditUntil($date, $accountId){
        // if ob_date dont exists or ob_date > $date
        // return credit untill
        // return sum of credit transaction between obdate and $date + Ob_amount
        $acc = Accounts::where('id',$accountId)->first();

        if(!$acc->ob_date || ($acc->ob_date > $date))
            $amount = self::where('secondary_account_id', $accountId)
                        ->until($date)
                        ->sum('amount');
        else
          $amount = self::creditBetween($acc->ob_date,$date,$accountId) + $acc->ob_amount;

        return round($amount,2);        
    }
     
    public static function debitUntil($date, $accountId){
        $acc = Accounts::where('id',$accountId)->first();
        
        if(!$acc->ob_date || ($acc->ob_date > $date))
          $amount = self::where('primary_account_id', $accountId)
                        ->until($date)
                        ->sum('amount');
        else
          $amount = self::debitBetween($acc->ob_date,$date,$accountId);     
                                     
        return round($amount,2);        
    }

    public function scopeBetween($query, $from, $to){
        return $query->where('transaction_date', '>=', $from)
                    ->where('transaction_date', '<=', $to);
    }

    public function scopeWhereAccountID($query, $accId){
        return $query->where(function($query) use ($accId){
            $query->where('primary_account_id', $accId)
                  ->orWhere('secondary_account_id', $accId);
        });            
    }

    public function scopeUntil($query, $to){
        return $query->where('transaction_date', '<=', $to);
    }
     
    function laborPayment()
    {
        return $this->hasOne(LaborPayments::class, 'transaction_id', 'id');   
    }

    function primaryAccount()
    {
        return $this->hasOne(Accounts::class, 'id', 'primary_account_id');   
    }
      
    function secondaryAccount()
    {
        return $this->hasOne(Accounts::class, 'id', 'secondary_account_id');   
    }

    static function closingBalance($toDate, $primaryAccountId)
    {   
        if(empty($toDate))
            $toDate = date('Y-m-d');

        return Transactions::balanceTill($toDate,$primaryAccountId);
    }

    public static function openingBalance($fromDate, $accountId)
    {     
        $fromDate = date('Y-m-d', strtotime($fromDate . ' -1 day'));
        return Transactions::balanceTill($fromDate,$accountId);
    }
}
