<?php

namespace App\Http\Controllers\Vacancy\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionEdit;
use Illuminate\Support\Facades\Gate;

class Edit extends ActionEdit
{
  protected $model=["\Vacancy\VacancyCategory"];

  protected function beforeEdit($id,&$arr)
  {
   if(!array_key_exists("parentID",$arr))
   {
    $arr["parentID"]=0;
   }
  }

  public function go($id,Request $request)
  {
   return $this->update($id,$request->all());
  }
  protected function denies($id)
  {
    if(Gate::denies('edit-vacancy-category'))
    {
     return [0];
    }
  }
}
