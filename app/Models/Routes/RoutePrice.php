<?php

namespace App\Models\Routes;

use Illuminate\Database\Eloquent\Model;

class RoutePrice extends Model
{
    protected $table="routes_price";
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    static public $data=array(
      "id"=>"id",
      "route"=>"route",
      "priceUAN"=>"price_uan",
      "priceUSD"=>"price_usd",
      "pricePLN"=>"price_pln",
      "priceEUR"=>"price_eur",
      "author"=>"author",
      "active"=>"active"
    );
    static public $filter=array(
       "routeID"=>[1,0,6],
       "priceUAN"=>[1,0,6],
       "priceUSD"=>[1,0,6],
       "pricePLN"=>[1,0,6],
       "priceEUR"=>[1,0,6],
       'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'routeID'=>['required'],
     'priceUAN'=>['required'],
     'pricePLN'=>['required']
    ];
    static public $columnID=[
     'route'=>'routeID'
    ];
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
