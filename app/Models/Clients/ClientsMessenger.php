<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Model;

class ClientsMessenger extends Model
{
    //
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    protected $table="clients_messenger";
    static public $data=array(
     "id"=>"id",
     "client"=>"client",
     "messenger"=>"messenger",
     "active"=>"active"
    );
    static public $filter=array(
     "client"=>[1,6,6],
     "messenger"=>[1,6,6],
     'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'client'=>['required'],
     'messenger'=>['required']
    ];
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
