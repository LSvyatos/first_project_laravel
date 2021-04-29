<?php

namespace App\Http\Controllers\Routes\Children;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionEdit;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class Edit extends ActionEdit
{
  protected $model=["\Routes\RouteChildren"];
  
  protected function afterEdit($id,&$params,&$arr)
  {
    $route=$this->models[0]::find($id);
    $time=$route->timeFrom();
    $routeTime=app("\App\Models\Routes\RouteStart");
    if(count($time->get())<=0)
    {
      $routeTime=new $routeTime;
      $routeTime->timeFrom=$params["timeFrom"];
      $routeTime->fromID=$params["fromID"];
      $routeTime->authorID=Auth::id();
      $route->timeFrom()->save($routeTime);
    }else{
      $route->timeFrom()->update([
        "timeFrom"=>$params["timeFrom"]
      ]);
    }
  }

  public function go($id,Request $request)
  {
   return $this->update($id,$request->all());
  }
  protected function denies($id)
  {
    if(Gate::denies('edit-routes'))
    {
     return [0];
    }
  }
}
