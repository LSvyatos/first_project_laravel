<?php

namespace App\Http\Controllers\Vacancy\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionCreate;
use Illuminate\Support\Facades\Auth;

class Create extends ActionCreate
{
   protected $model=["\Vacancy\VacancyCategory","\Vacancy\Category\Search"];

   //private $access=0;
   public function go(Request $request)
   {
    return $this->create($request->all());
   }
   protected function denies($id=0)
   {
    return [Gate::denies('search-vacancy-category')];
   }
}
