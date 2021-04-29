<?php

namespace App\Models\Vacancy;

use Illuminate\Database\Eloquent\Model;

class VacancyImages extends Model
{
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    static public $data=[
     "id"=>"id",
     "image"=>"image",
     "vacancy"=>"vacancy",
     "active"=>"active"
    ];
    static public $filter=[
     //"id"=>[0,false,0,2],
     "imageID"=>[1,0,2],
     "vacancyID"=>[1,0,2],
     'authorID'=>[1,6,6]
    ];
    static public $validationCreate=[
     'imageID'=>['required','min:1'],
     'vacancyID'=>['required','min:1']
    ];
    protected $table="vacancy_images";

    public function Vacancy()
    {
     //return $this->hasMany(Vacancy::class,'','');
    }
    public function images()
    {
     return $this->belongs(\App\Models\Images\Images::class,'imageID','id');
    }
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
