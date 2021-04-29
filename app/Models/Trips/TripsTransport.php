<?php

namespace App\Models\Trips;

use Illuminate\Database\Eloquent\Model;

class TripsTransport extends Model
{
    protected $table="trips_transport";
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    static public $data=array(
      "id"=>"id",
      "trip"=>"trip",
      "transport"=>"transport",
      "active"=>"active"
    );
    static public $filter=array(
       "tripID"=>[1,0,6],
       "transportID"=>[1,0,6],
       'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'trip'=>['required'],
     'transport'=>['required']
    ];
    static public $columnID=[
     'trip'=>'tripID',
     'transport'=>'transportID'
    ];
}
