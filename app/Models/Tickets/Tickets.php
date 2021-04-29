<?php

namespace App\Models\Tickets;

use Illuminate\Database\Eloquent\Model;

class Tickets extends Model
{
    //
    protected $hidden=['_delete'];
    static public $data=array(
      "id"=>"id",
      "uid"=>"uid",
      "type"=>"type",
      "perhap"=>"perhap",
      "unical"=>"unical",
      "trip"=>"trip",
      "from"=>"_from",
      "to"=>"_to",
      "transport"=>"transport",
      "client"=>"client",
      "clientText"=>"client_text",
      "price"=>"price",
      "priceType"=>"price_type",
      "payType"=>"pay_type",
      "timeFrom"=>"_from_time",
      "text"=>"text",
      "author"=>"author",
      "timeCreate"=>"created_at",
      "active"=>"active"
    );
    static public $filter=array(
       "perhapID"=>[0,0,6],
       "type"=>[0,0,6],
       "tripID"=>[1,0,6],
       "fromID"=>[1,0,6],
       "toID"=>[1,0,6],
       "routeID"=>[1,0,6],
       "clientID"=>[1,0,6],
       "clientText"=>[0,0,6],
       "price"=>[0,0,6],
       "timeFrom"=>[0,0,6],
       "currencyID"=>[0,0,6],
       "typePaymentID"=>[0,0,6],
       "created_at"=>[0,0,6],
       "transportID"=>[0,0,6],
       "routeID"=>[0,0,6],
       "text"=>[0,6,6],
       'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'tripID'=>['required'],
     'fromID'=>['required'],
     'toID'=>['required'],
     'routeID'=>['required'],
     'clientID'=>['required'],
     'perhapID'=>['required'],
     'currencyID'=>['required'],
     'typePaymentID'=>['required'],
     'transportID'=>['required']
    ];
    static public $columnID=[
      'trip'=>'tripID',
      'perhap'=>'perhapID',
      'from'=>'fromID',
      'to'=>'toID',
      'transport'=>'transportID',
      'route'=>'routeID',
      'currency'=>'currencyID',
      'typePayment'=>'typePaymentID'
    ];
    public function from()
    {
     return $this->belongsTo(\App\Models\Geography\City::class,'fromID','id');
    }
    public function to()
    {
     return $this->belongsTo(\App\Models\Geography\City::class,'toID','id');
    }
    public function perhap()
    {
      return $this->belongsTo(\App\Models\Trips\TripsPerhaps::class,'perhapID','id');
    }
    public function client()
    {
     return $this->belongsTo(\App\Models\Clients\Clients::class,'clientID','id');
    }
    public function transport()
    {
     return $this->belongsTo(\App\Models\Transport\Transport::class,'transportID','id');
    }
    public function getTrip()
    {
     return $this->belongsTo(\App\Models\Trips\Trips::class,'tripID','id');
    }
    public function currency()
    {
      return $this->belongsTo(\App\Models\Data\Currency::class,'currencyID','id');
    }
    public function typePayment()
    {
      return $this->belongsTo(\App\Models\Data\TypePayment::class,'typePaymentID','id');
    }
    public function Trips()
    {
      return \App\Models\Trips\Trips::class;
    }
    public function Clients()
    {
      return \App\Models\Clients\Clients::class;
    }
    public function mPerhaps()
    {
      return \App\Models\Trips\TripsPerhaps::class;
    }
    public function Routes()
    {
      return \App\Models\Routes\RouteChildren::class;
    }
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
    public function drivers()
    {
      return $this->hasManyThrough(
        \App\Models\Users\Users::class,
        \App\Models\Trips\TripsDrivers::class,
        'tripID',
        'id',
        'tripID',
        'userID'
      );
      
    }
}
