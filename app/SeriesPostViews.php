<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeriesPostViews extends Model
{
    protected $table = 'series_post_views';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['series_list_id','image_view','value','pan_view'];
}
