<?php

namespace App\Models\Clients;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    //
    protected $table="clients";
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    static public $data=array(
     "id"=>"id",
     "name"=>"name",
     "lastname"=>"lastname",
     "surname"=>"surname",
     "text"=>"text",
     "active"=>"active"
    );
    static public $filter=array(
     "name"=>[1,6,6],
     "lastname"=>[1,6,6],
     "surname"=>[1,6,6],
     "text"=>[0,6,6],
     'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'name'=>['required'],
     'lastname'=>['required']
    ];

    public function address()
    {
     return $this->hasMany(ClientsAddress::class, 'clientID', 'id');
    }
    public function getAddress()
    {
        return $this->hasManyThrough(
            \App\Models\Geography\City::class,
            ClientsAddress::class,
            'clientID',
            'id',
            'id',
            'cityID'
        );
    }
    public function Messenger()
    {
     return $this->hasMany(ClientsMessenger::class, 'clientID', 'id')->select(['id','messenger']);
    }
    public function Phones()
    {
     return $this->hasMany(ClientsPhones::class, 'clientID', 'id')->select(['id','phoneFormat as phone']);
    }
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
