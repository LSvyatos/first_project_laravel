<?php

namespace App\Http\Controllers\Applications;

use Illuminate\Http\Request;
use App\Http\Controllers\System\Response;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;
//use App\Models\Vacancy\Vacancy;


class Get extends ActionGet
{
  protected $model=["\Applications\Applications"];
  protected function denies($id)
  {
   return [Gate::denies('get-applications')];
  }
  protected function inFor(&$arr)
  {
   //$this->models=["\App\Models\Vacancy\VacancyImages"];

  }
  public function go($id)//Клас для виклику з роутера
  {
   $this->setId([$id]);
   return $this->get();
  }
}
