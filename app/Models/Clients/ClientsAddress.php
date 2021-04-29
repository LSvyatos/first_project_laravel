<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Model;

class ClientsAddress extends Model
{
    //
    protected $table="clients_address";
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    static public $data=array(
       "id"=>"id",
       "client"=>"client",
       "city"=>"city",
       "name"=>"name",
       "active"=>"active"
    );
    static public $filter=array(
     "clientID"=>[1,6,6],
     "city"=>[1,6,6],
     "name"=>[1,6,6],
     'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'clientID'=>['required'],
     'city'=>['required']
    ];
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
