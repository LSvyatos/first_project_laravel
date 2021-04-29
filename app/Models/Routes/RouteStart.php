<?php

namespace App\Models\Routes;

use Illuminate\Database\Eloquent\Model;

class RouteStart extends Model
{
    protected $table="routes_start";
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    static public $data=array(
      "id"=>"id",
      "route"=>"route",
      "timeFrom"=>"_from_time",
      "author"=>"author",
      "active"=>"active"
    );
    static public $filter=array(
       "routeID"=>[1,0,6],
       "fromID"=>[1,0,6],
       "timeFrom"=>[1,0,6],
       'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'routeID'=>['required'],
     'fromID'=>['required'],
     'timeFrom'=>['required']
    ];
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
