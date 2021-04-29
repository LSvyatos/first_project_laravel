<?php

namespace App\Http\Controllers\Vacancy\Clients;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionSearch;
use Illuminate\Support\Facades\Gate;

class Search extends ActionSearch
{
  protected $model=["\Vacancy\VacancyClients","\Vacancy\Clients\Get"];


  public function go(Request $request)
  {
   self::setParams($request->all());

   return self::get();
  }

  protected function denies($id=0)
  {
   return Gate::denies('search-vacancy-clients');
  }
  protected function word(&$query)
  {
   //;
  }
}
