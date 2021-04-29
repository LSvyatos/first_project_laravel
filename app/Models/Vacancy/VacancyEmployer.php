<?php

namespace App\Models\Vacancy;

use Illuminate\Database\Eloquent\Model;

class VacancyEmployer extends Model
{
    protected $table="vacancy_employer";
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
}
