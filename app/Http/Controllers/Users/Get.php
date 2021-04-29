<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use App\Http\Controllers\System\Response;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;

class Get extends ActionGet
{
  protected $model=["\Users\Users"];
  protected function denies($id)
  {
   return [Gate::denies('get-users')];
  }
  /*protected function inFor(&$arr)
  {
   //$this->models=["\App\Models\Vacancy\VacancyImages"];
   $privileges=app("App\Http\Controllers\Users\Privileges\Get");
   $privil=$privileges->go($arr->id);
   if($privil["status"]==200)
   {
    $arr->role=$privil["value"][0]["privilege"];
   }
  }*/
  protected function inFor(&$arr)
  {
    $arr["a_address"]=$arr->getAddress()->get();
    if(empty($this->select)||in_array("phones",$this->select))
    {
      $arr->phones;
    }
  }
  public function go($id)//Клас для виклику з роутера
  {
   $this->setId([$id]);
   return $this->get();
  }
}
