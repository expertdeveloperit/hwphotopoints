<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeriesPosts extends Model
{
     protected $table = 'series_posts';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['series_id','title','year'];
}
