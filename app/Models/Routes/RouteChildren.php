<?php

namespace App\Models\Routes;

use Illuminate\Database\Eloquent\Model;

class RouteChildren extends Model
{
    protected $table="routes_route";
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    static public $data=array(
      "id"=>"id",
      "route"=>"route",
      "fromID"=>"_from",
      "toID"=>"_to",
      "fromName"=>"_from_name",
      "toName"=>"_to_name",
      "priceUAN"=>"price_uan",
      "pricePLN"=>"price_pln",
      "priceUSD"=>"price_usd",
      "priceEUR"=>"price_eur",
      "text"=>"text",
      "author"=>"author",
      "active"=>"active"
    );
    static public $filter=array(
       "routeID"=>[1,0,6],
       "fromID"=>[1,0,6],
       "toID"=>[1,0,6],
       "fromName"=>[0,0,6],
       "toName"=>[0,0,6],
       "priceUAN"=>[0,0,6],
       "pricePLN"=>[0,0,6],
       "priceUSD"=>[0,0,6],
       "priceEUR"=>[0,0,6],
       "text"=>[0,6,6],
       'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'routeID'=>['required'],
     'fromID'=>['required'],
     'toID'=>['required'],
     //'nameFrom'=>['required'],
     //'nameTo'=>['required']
    ];
    public function from()
    {
      return $this->hasOne(\App\Models\Geography\City::class, 'id', 'fromID')->select(['id','name']);
    }
    public function to()
    {
      return $this->hasOne(\App\Models\Geography\City::class, 'id', 'toID')->select(['id','name']);
    }
    public function route()
    {
     return $this->hasOne(Route::class, 'id', 'routeID')->select(['id','name','fromName','toName']);
    }
    public function timeFrom()
    {
     return $this->hasOne(RouteStart::class, 'routeID', 'routeID')->where('fromID',$this->fromID)->select(['id','timeFrom as time']);
    }
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
