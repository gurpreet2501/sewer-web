<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class GEIssuedBags extends Model
{
    protected $table = 'ge_issued_bags';
    protected $fillable = ['ge_bag_type_id','date','user_id','no_of_bags'];

}
