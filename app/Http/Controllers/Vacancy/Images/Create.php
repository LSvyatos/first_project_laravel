<?php

namespace App\Http\Controllers\Vacancy\Images;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionCreate;
use Illuminate\Support\Facades\Auth;

class Create extends ActionCreate
{
   protected $model=["\Vacancy\VacancyImages","\Vacancy\Images\Search"];

   //private $access=0;
   public function go(Request $request)
   {
    $data=$request->all();
    $status=["status"=>0];
    if(!array_key_exists("images",$data))
    {
     return $status;
    }
    foreach($data["images"] as $k=>$v)
    {
     $status=$this->create(["vacancyID"=>$data["vacancyID"],"imageID"=>$v]);
    }
    return $status;
   }
   protected function denies($id=0)
   {
    return [Gate::denies('search-vacancy')];
   }
}
