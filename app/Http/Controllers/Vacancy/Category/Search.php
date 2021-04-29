<?php

namespace App\Http\Controllers\Vacancy\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionSearch;
use Illuminate\Support\Facades\Gate;
//use App\Models\Vacancy\Vacancy;

class Search extends ActionSearch
{
  protected $model=["\Vacancy\VacancyCategory","\Vacancy\Category\Get"];


  public function go(Request $request)
  {
   self::setParams($request->all());

   return self::get();
  }
  protected function word(&$query)
  {
   $query->where('name','like','%'.$this->word.'%')
         ->orWhere('description','like','%'.$this->word.'%')
         ->orWhere('id','like','%'.$this->word.'%');
  }
  protected function denies($id=0)
  {
   return Gate::denies('search-vacancy-category');
  }
}
