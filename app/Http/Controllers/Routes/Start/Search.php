<?php

namespace App\Http\Controllers\Routes\Start;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionSearch;
use Illuminate\Support\Facades\Gate;

class Search extends ActionSearch
{
  protected $model=["\Routes\RouteStart","\Routes\Start\Get"];


  protected function denies($id=0)
  {
   return Gate::denies('search-routes');
  }
  protected function word(&$query)
  {
   //
  }
}