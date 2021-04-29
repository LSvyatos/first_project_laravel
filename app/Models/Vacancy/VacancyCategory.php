<?php

namespace App\Models\Vacancy;

use Illuminate\Database\Eloquent\Model;

class VacancyCategory extends Model
{
    protected $fillable = ['author'];
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    static public $data=[
     "id"=>"id",
     "parent"=>"parent",
     "name"=>"name",
     "description"=>"description",
     "author"=>"author",
     "active"=>"active"
    ];
    static public $filter=[
     "description"=>[0,6,6],
     "name"=>[1,0,6],
     "parentID"=>[1,0,6],
     'authorID'=>[1,6,6]
    ];
    static public $validationCreate=[
     'parentID'=>['number'],
     'description'=>['min:1'],
     'name'=>['required']
    ];
    static public $columnID=[
     'parent'=>'parentID'
    ];
    protected $table="vacancy_category";

    public function vacancy()
    {
     return $this->hasMany(Vacancy::class, 'id', 'category');
    }
    public function parent()
    {
     return $this->belongsTo(VacancyCategory::class, 'parentID', 'id');
    }
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
