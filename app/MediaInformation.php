<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaInformation extends Model
{
      protected $table = 'media_information';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id','file_name','file_location_aws','file_thumb_location_aws','uploaded_by','uploading_date','year','season','series','image_view','views','post_name'];
}
