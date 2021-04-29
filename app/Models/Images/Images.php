<?php

namespace App\Models\Images;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    //protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    protected $table = "images";
    static public $data=array(
     "name"=>"name",
     "url"=>"url",
     "urlIn"=>"url_in",
     "type"=>"type",
     "author"=>"author"
    );
    static public $filter=array(
     "name"=>[0,0,2],
     "url"=>[1,0,2],
     "urlIn"=>[1,0,2],
     "type"=>[1,0,2],
     'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
      'img'=>['required','file','image','dimensions','max_width=500','max_height=500']
    ];
}
