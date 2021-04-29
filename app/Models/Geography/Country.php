<?php

namespace App\Models\Geography;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $table="geo_country";
    protected $hidden=['_delete','laravel_through_key','created_at','updated_at','active'];
    static public $data=array(
     "id"=>"id",
     "name"=>"name",
     "active"=>"active"
    );
    static public $filter=array(
     "name"=>[1,0,6],
     'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'name'=>['required']
    ];
    public function city()
    {
     return $this->hasMany(City::class,'id','country');
    }
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
