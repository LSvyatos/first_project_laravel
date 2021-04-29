<?php

namespace App\Http\Controllers\Vacancy\House;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;

class Get extends ActionGet
{
    //
    protected $model=['\Vacancy\VacancyHouse'],
              $key="vacancy";
    protected function denies($id=0)
    {
     $gate=Gate::denies('get-vacancy-house');
     return [$gate];
    }
}
