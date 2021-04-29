<?php

namespace App\Http\Controllers\Routes;

use Illuminate\Http\Request;
use App\Http\Controllers\System\Response;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;

class Get extends ActionGet
{
  protected $model=["\Routes\Route"];
  protected function denies($id)
  {
   return [Gate::denies('get-routes')];
  }
  protected function inFor(&$arr)
  {
   if(isset($arr->fromID))
   {
    $arr->from;
   }
   if(isset($arr->toID))
   {
    $arr->to;
   }
   if(isset($arr->fromTime))
   {
    $arr->timeFrom;
   }
  }
  public function go($id)//Клас для виклику з роутера
  {
   $this->setId([$id]);
   return $this->get();
  }
}
