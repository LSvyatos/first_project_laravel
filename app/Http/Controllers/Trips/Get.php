<?php

namespace App\Http\Controllers\Trips;

use Illuminate\Http\Request;
use App\Http\Controllers\System\Response;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;
//use App\Models\Vacancy\Vacancy;


class Get extends ActionGet
{
  protected $model=["\Trips\Trips"];

  protected function denies($id)
  {
   return [Gate::denies('get-trips')];
  }
  protected function inFor(&$arr)
  {
   //$this->models=["\App\Models\Vacancy\VacancyImages"];
   if(isset($arr->fromID))
   {
    $arr->from;
   }
   if(isset($arr->toID))
   {
    $arr->to;
   }
   if(isset($arr->routeID))
   {
    $arr->route;
   }
   if(isset($arr->stewardID))
   {
    $arr->steward=$arr->steward;
   }
   if(isset($arr->transportID))
   {
    $arr->transport;
   }
   $arr["drivers"]=$arr->driver()->get();
  }
  public function go($id)//Клас для виклику з роутера
  {
   $this->setId([$id]);
   return $this->get();
  }
}
