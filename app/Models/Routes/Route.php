<?php

namespace App\Models\Routes;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
  protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    protected $table="routes";
    static public $data=array(
      "id"=>"id",
      "name"=>"name",
      "fromID"=>"_from",
      "toID"=>"_to",
      "fromName"=>"_from_name",
      "toName"=>"_to_name",
      "timeFrom"=>"_from_time",
      "author"=>"author",
      "text"=>"text",
      "active"=>"active"
    );
    static public $filter=array(
       "name"=>[1,0,6],
       "fromID"=>[1,0,6],
       "toID"=>[1,0,6],
       "fromName"=>[0,0,6],
       "toName"=>[0,0,6],
       "timeFrom"=>[0,0,6],
       "text"=>[0,6,6],
       'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'name'=>['required','min:1'],
     'fromID'=>['required'],
     'toID'=>['required']
    ];
    static public $columnID=[
     'from'=>'fromID',
     'to'=>'toID'
    ];
    public function Price()
    {
     return RoutePrice::class;
    }
    public function Start()
    {
     return RouteStart::class;
    }
    public function Children()
    {
     return RouteChildren::class;
    }
    public function from()
    {
      return $this->hasOne(\App\Models\Geography\City::class, 'id', 'fromID')->select(['id','name']);
    }
    public function to()
    {
      return $this->hasOne(\App\Models\Geography\City::class, 'id', 'toID')->select(['id','name']);
    }
    public function timeFrom()
    {
     return $this->hasOne(RouteStart::class, 'fromID', 'fromID')->where('routeID',$this->id)->select(['id','timeFrom as time']);
    }
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
