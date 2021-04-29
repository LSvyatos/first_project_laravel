<?php

namespace App\Models\Vacancy;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    protected $table="vacancy";
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    static public $data=array(
     "id"=>"id",
     "name"=>"name",
     "description"=>"desc",
     "duties"=>"duties",
     "requirements"=>"requirements",
     "schedule"=>"schedule",
     "visa"=>"visa",
     "minMonthVisa"=>"min_month_visa",
     "sex"=>"sex",
     "minYear"=>"min_year",
     "maxYear"=>"max_year",
     "maxTimeDay"=>"max_time_day",
     "maxTimeWeek"=>"max_time_week",
     "maxTimeMonth"=>"max_time_month",
     "bonus"=>"bonus",
     "minPaymentSuma"=>"payment_min_suma",
     "maxPaymentSuma"=>"payment_max_suma",
     "paymentPeriod"=>"payment_period",
     "city"=>"city",
     "category"=>"category",
     "number"=>"number",
     "food"=>"food",
     "house"=>"house",
     "logo"=>"logo",
     "urgently"=>"urgently",
     "changes"=>"changes",
     "skillLanguage"=>"skill_language",
     "authorID"=>"author",
     "workSeason"=>"work_season",
     "experience"=>"experience",
     "text"=>"text",
     "active"=>"active"
    );
    static public $filter=array(
     "name"=>[1,0,2],
     "description"=>[1,0,2],
     "duties"=>[0,0,2],
     "requirements"=>[0,0,2],
     "schedule"=>[0,0,2],
     "visa"=>[0,0,2],
     "minMonthVisa"=>[0,0,2],
     "sex"=>[0,0,2],
     "minYear"=>[0,0,2],
     "maxYear"=>[0,0,2],
     "maxTimeDay"=>[0,0,2],
     "maxTimeWeek"=>[0,0,2],
     "maxTimeMonth"=>[0,0,2],
     "bonus"=>[0,[0,1],0,2],
     "minPaymentSuma"=>[0,0,2],
     "maxPaymentSuma"=>[0,0,2],
     "paymentPeriod"=>[0,0,2],
     "cityID"=>[0,0,2],
     "categoryID"=>[0,7,2],
     "number"=>[0,0,2],
     "food"=>[0,0,2],
     "house"=>[0,0,2],
     "logo"=>[0,0,2],
     "urgently"=>[0,0,2],
     "changes"=>[1,0,2],
     "skillLanguage"=>[0,0,2],
     "experience"=>[0,0,2],
     "workSeason"=>[0,0,2],
     "text"=>[0,6,6],
     "active"=>[0,0,2],
     'authorID'=>[1,6,6]
    );

    static public $validationCreate=[
     'name'=>['required','min:1'],
     'description'=>['required','min:1'],
     'visa'=>['required','numeric'],
     'sex'=>['required','numeric'],
     'minPaymentSuma'=>['required'],
     'paymentPeriod'=>['required','numeric'],
     'number'=>['required','numeric'],
     'changes'=>['required','numeric'],
     'categoryID'=>['required','numeric','min:1'],
     'cityID'=>['required','numeric','min:1'],
     'minYear'=>['required'],
     'maxYear'=>['required']
    ];

    static public $columnID=[
     'vacancy'=>'vacancyID',
     'city'=>'cityID',
     'category'=>'categoryID'
    ];

    public function City()
    {
     return $this->belongsTo(\App\Models\Geography\City::class, 'cityID', 'id')->select(["id","name"]);
    }
    public function Category()
    {
     return $this->belongsTo(VacancyCategory::class, 'categoryID', 'id')->select(["id","name"]);
    }
    public function Image()
    {
     return $this->hasMany(VacancyImages::class, 'vacancyID', 'id');
     /*$this->hasManyThrough(
          \App\Models\Images\Images::class,
          VacancyImages::class,
          'vacancyID',
          'id',
          'id',
          'imageID'
          );*/
    }
    public function employers()
    {
        return $this->hasMany(VacancyEmployer::class, 'vacancyID', 'id');
    }
    public function employer()
    {
        return $this->hasManyThrough(
            \App\Models\Users\Users::class,
            VacancyEmployer::class,
            'vacancyID',
            'id',
            'id',
            'userID'
        );
    }
    public function Images()
    {
     return $this->hasManyThrough(
               \App\Models\Images\Images::class,
               VacancyImages::class,
               'vacancyID',
               'id',
               'id',
               'imageID'
               );
    }
    public function employersa()
    {
      return $this->hasManyThrough(
        \App\Models\Users\UsersAddress::class,
        \App\Models\Vacancy\VacancyEmployer::class,
        'vacancyID',
        'userID',
        'vacancyID',
        'userID'
      );
      
    }
    public function Clients()
    {
     return $this->hasMany(VacancyClients::class, 'vacancyID', 'id');
    }
    public function House()
    {
     return $this->hasMany(VacancyHouse::class, 'vacancyID', 'id');
    }
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
