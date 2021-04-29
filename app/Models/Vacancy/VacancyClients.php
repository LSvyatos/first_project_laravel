<?php

namespace App\Models\Vacancy;

use Illuminate\Database\Eloquent\Model;

class VacancyClients extends Model
{
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    static public $data=[
     "id"=>"id",
     "vacancy"=>"vacancy",
     "client"=>"client",
     "fromTime"=>"_from",
     "toTime"=>"_to",
     "active"=>"active"
    ];
    static public $filter=[
     "vacancy"=>[1,6,6],
     "client"=>[1,6,6],
     "fromTime"=>[0,6,6],
     "toTime"=>[0,6,6],
     'authorID'=>[1,6,6]
    ];
    static public $validationCreate=[
     'vacancyID'=>['required','min:1'],
     'clientID'=>['required','min:1'],
     'timeFrom'=>['min:1'],
     'timeTo'=>['min:1']
    ];
    protected $table="vacancy_clients";
    public function Vacancy()
    {
     return $this->belongsTo(Vacancy::class,'vacancy','id');
    }
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
