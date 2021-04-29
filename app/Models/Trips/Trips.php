<?php

namespace App\Models\Trips;

use Illuminate\Database\Eloquent\Model;

class Trips extends Model
{
    protected $table="trips";
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    static public $data=array(
      "id"=>"id",
      "route"=>"route",
      "from"=>"_from",
      "to"=>"_to",
      "text"=>"text",
      "timeFrom"=>"_from_time",
      "transport"=>"transport",
      "drivers"=>"drivers",
      "zvitUAN"=>"zvit_uan",
      "zvitPLN"=>"zvit_pln",
      "zvitUSD"=>"zvit_usd",
      "zvitEUR"=>"zvit_eur",
      "steward"=>"steward",
      "author"=>"author",
      "active"=>"active"
    );
    static public $filter=array(
       "routeID"=>[1,0,6],
       "fromID"=>[1,0,6],
       "toID"=>[1,0,6],
       "timeFrom"=>[1,0,6],
       "stewardID"=>[1,0,6],
       "transportID"=>[1,0,6],
       
       "zvitUAN"=>[0,6,6],
       "zvitPLN"=>[0,6,6],
       "zvitUSD"=>[0,6,6],
       "zvitEUR"=>[0,6,6],
       "text"=>[1,6,6],
       "active"=>[0,0,6],
       'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'routeID'=>['required'],
     'fromID'=>['required'],
     'toID'=>['required'],
     "transportID"=>["required"],
     'stewardID'=>['required'],
     'timeFrom'=>['required'],
     'drivers'=>['required']
    ];
    static public $columnID=[
     'from'=>'fromID',
     'to'=>'toID',
     'transport'=>'transportID',
     'steward'=>'stewardID',
     'route'=>'routeID'
    ];
    public function drivers()
    {
      return $this->hasMany(\App\Models\Trips\TripsDrivers::class, 'tripID', 'id')->select(['id','userID']);
    }
    public function driver()
    {
      return $this->hasManyThrough(
        \App\Models\Users\Users::class,
        TripsDrivers::class,
        'tripID',
        'id',
        'id',
        'userID'
      );
    }
    public function from()
    {
      return $this->belongsTo(\App\Models\Geography\City::class, 'fromID', 'id')->select(['id','name']);
    }
    public function to()
    {
      return $this->belongsTo(\App\Models\Geography\City::class, 'toID', 'id')->select(['id','name']);
    }
    public function route()
    {
     return $this->belongsTo(\App\Models\Routes\Route::class, 'routeID', 'id')->select(['id','name','fromName','toName']);
    }
    public function transport()
    {
     return $this->belongsTo(\App\Models\Transport\Transport::class,'transportID', 'id')->select(['id','name']);
    }
    public function steward()
    {
     return $this->belongsTo(\App\Models\Users\Users::class, 'stewardID', 'id')->select(['id','name','lastname']);
    }
    public function mRoute()
    {
      return \App\Models\Routes\Route::class;
    }
    public function Perhaps()
    {
     return TripsPerhaps::class;
    }
    public function Position()
    {
     return TripsPosition::class;
    }
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
