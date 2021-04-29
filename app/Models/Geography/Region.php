<?php

namespace App\Models\Geography;

use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    protected $table="geo_region";
    protected $hidden=['_delete','laravel_through_key','created_at','updated_at','active'];
    static public $data=array(
     "id"=>"id",
     "name"=>"name",
     "country"=>"country",
     "active"=>"active"
    );
    static public $filter=array(
     "name"=>[1,0,6],
     "countryID"=>[1,0,6],
     'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'name'=>['required'],
     'countryID'=>['required']
    ];
    static public $columnID=[
     'region'=>'regionID',
     'country'=>'countryID'
    ];
    public function country()
    {
     return $this->belongsTo(Country::class, 'countryID', 'id');
    }
    public function city()
    {
     return $this->belongsTo(City::class,'id','countryID');
    }
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
