<?php

namespace App\Vacancy;

use Illuminate\Database\Eloquent\Model;

class VacancyHouse extends Model
{
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    static public $data=[
     "id"=>"id",
     "vacancy"=>"vacancy",
     "name"=>"name",
     "city"=>"city",
     "position"=>"position",
     "active"=>"active"
    ];
    static public $filter=[
     "vacancy"=>[1,6,6],
     "name"=>[1,6,6],
     "city"=>[1,6,6],
     "position"=>[0,6,6],
     'authorID'=>[1,6,6]
    ];
    static public $validationCreate=[
     'vacancy'=>['required','min:1'],
     'name'=>['required','min:1'],
     'city'=>['required','min:1'],
     'position'=>['min:1']
    ];
    protected $table="vacancy_house";

    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
