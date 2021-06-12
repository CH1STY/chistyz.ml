<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
   
    public function user()
    {
        return $this->belongsTo(App\User::class, 'user_id', 'user_id');
    }
    protected $fillable = array('user_id','image','fullname');
    public $timestamps = false;
}
