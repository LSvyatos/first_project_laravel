<?php

namespace App\Models\Trips;

use Illuminate\Database\Eloquent\Model;

class TripsPerhaps extends Model
{
    protected $table="trips_perhaps";
    protected $fillable=["ticketID"];
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    static public $data=array(
      "id"=>"id",
      "trip"=>"trip",
      "perhap"=>"perhap",
      "ticket"=>"ticket",
      "transport"=>"transport",
      "active"=>"active"
    );
    static public $filter=array(
       "tripID"=>[1,0,6],
       "perhapID"=>[1,0,6],
       "ticketID"=>[1,0,6],
       "transportID"=>[1,0,6],
       'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'tripID'=>['required'],
     'perhapID'=>['required'],
     'ticketID'=>['required'],
     'transportID'=>['required']
    ];
    static public $columnID=[
     'trip'=>'tripID',
     'ticket'=>'ticketID',
     'transport'=>'transportID',
     'perhap'=>'perhapID'
    ];
}
