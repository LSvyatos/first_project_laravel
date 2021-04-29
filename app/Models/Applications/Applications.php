<?php

namespace App\Models\Applications;

use Illuminate\Database\Eloquent\Model;

class Applications extends Model
{
    //
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    static public $data=array(
     'client'=>'client',
     'status'=>'status',
     'vacancy'=>'vacancy',
     'name'=>'name',
     'lastname'=>'lastname',
     'surname'=>'surname',
     'user'=>'user',
     'active'=>'active',
     'text'=>'text'
    );
    static public $filter=array(
     'clientID'=>[1,6,6],
     'status'=>[0,6,6],
     'vacancyID'=>[1,6,6],
     'name'=>[0,6,6],
     'lastname'=>[0,6,6],
     'surname'=>[0,6,6],
     'text'=>[0,6,6],
     'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'vacancyID'=>['required'],
     'name'=>['required'],
     'lastname'=>['required']
    ];
    public function client()
    {
     return $this->belongsTo(\App\Models\Clients\Clients::class,'countryID','id');
    }
    public function vacancy()
    {
     return $this->belongsTo(\App\Models\Vacancy\Vacancy::class,'vacancyID','id');
    }
    public function user()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'userID','id');
    }
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
