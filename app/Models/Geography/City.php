<?php

namespace App\Models\Geography;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $table="geo_city";
    protected $hidden=['_delete','laravel_through_key','created_at','updated_at','active'];
    static public $data=array(
     "id"=>"id",
     "name"=>"name",
     "country"=>"country",
     "region"=>"region",
     "type"=>"type",
     "active"=>"active"
    );
    static public $filter=array(
     "name"=>[1,0,6],
     "type"=>[1,0,6],
     "regionID"=>[1,0,6],
     "countryID"=>[1,0,6],
     'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'name'=>['required'],
     'type'=>['required'],
     'countryID'=>['required'],
     'regionID'=>['required']
    ];
    static public $columnID=[
     'country'=>'countryID',
     'region'=>'regionID'
    ];
    public function country()
    {
     return $this->belongsTo(Country::class, 'countryID', 'id')->select('id','name');
    }
    public function region()
    {
     return $this->belongsTo(Region::class, 'regionID', 'id')->select('id','name');
    }
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
