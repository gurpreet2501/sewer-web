<?php
namespace Models;
use Illuminate\Database\Eloquent\Model;

class UserSessions extends Model
{ 
    protected $table    = 'user_sessions';
    protected $fillable    = ['user_id', 'token'];

}
