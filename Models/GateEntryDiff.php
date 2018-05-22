<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class GateEntryDiff extends Model
{
	protected $table    = 'gate_entry_diff';
	protected $fillable = ['user_id','data','gate_entry_id','edited_at'];
}
