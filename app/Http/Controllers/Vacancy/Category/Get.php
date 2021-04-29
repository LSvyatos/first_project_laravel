<?php

namespace App\Http\Controllers\Vacancy\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;
use Illuminate\Support\Facades\Auth;
class Get extends ActionGet
{
    //
    protected $model=['\Vacancy\VacancyCategory'];

    protected function denies($id=0)
    {
     $gate=Gate::denies('get-vacancy-category');
     return [$gate];
    }
    public function inFor(&$arr)
    {
     if(isset($arr->parentID))
     {
      $arr->parent;
     }
    }
}
