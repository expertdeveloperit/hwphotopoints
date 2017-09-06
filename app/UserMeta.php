<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    protected $table = 'user_meta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['role','first_name','last_name','biography','gender','country','profile_img'];
    public function user() {
        return $this->belongsTo('App\User','id');
    }
}
