<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Model;

class ClientsPhones extends Model
{
    //
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    static public $data=array(
      "id"=>"id",
      "client"=>"client",
      "code"=>"code",
      "country"=>"country",
      "phone"=>"phone",
      "phoneFormat"=>"phone_format",
      "active"=>"active"
    );
    static public $filter=array(
     "clientID"=>[1,6,6],
     "code"=>[1,6,6],
     "country"=>[1,6,6],
     "phone"=>[1,6,6],
     "phoneFormat"=>[1,6,6],
     'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'clientID'=>['required'],
     'code'=>['required'],
     'country'=>['required'],
     'phone'=>['required']
    ];
    protected $table="clients_phones";
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
