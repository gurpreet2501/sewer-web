<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class ErrorLogs extends Model
{
    protected $table    = 'error_logs';
    protected $fillable    = ['error','file_name','line_no','function_input'];

}
