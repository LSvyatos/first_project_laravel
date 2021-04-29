<?php

namespace App\Http\Controllers\Vacancy\Clients;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionCreate;
use Illuminate\Support\Facades\Auth;

class Create extends ActionCreate
{
   protected $model=["\Vacancy\VacancyClients","\Vacancy\Clients\Search"];

   //private $access=0;
   public function go($vacancy,Request $request)
   {
    $params=array_merge(["vacancy"=>$vacancy],$request->all());
    return $this->create($params);
   }
   protected function denies($id=0)
   {
    return [Gate::denies('create-vacancy-clients')];
   }
}
