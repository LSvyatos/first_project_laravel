<?php

namespace App\Http\Controllers\Routes\Children;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionCreate;
use Illuminate\Support\Facades\Auth;

class Create extends ActionCreate
{
   protected $model=["\Routes\RouteChildren","\Routes\Children\Search"];

   //private $access=0;
   protected function beforeCreate(&$arr)
   {
      $fromName=\App\Models\Geography\City::where('id',$arr['fromID'])->first();
      $toName=\App\Models\Geography\City::where('id',$arr['toID'])->first();
      $arr['fromName']=empty($fromName)?"":$fromName->name;
      $arr['toName']=empty($toName)?"":$toName->name;
   }
   protected function afterCreate($id,&$arr)
   {
      $time=app("\App\Models\Routes\RouteStart");
      $timeClass=app("\App\Http\Controllers\Routes\Start\Search")->getResult(
         [
            "filter"=>[
               "routeID"=>$arr["routeID"],
               "fromID"=>$arr["fromID"]
            ]
         ]
      );
      if($timeClass["status"]==200&&count($timeClass["value"])==0)
      {
         $time=new $time;
         $time->fromID=$arr["fromID"];
         $time->timeFrom=$arr["timeFrom"];
         $time->authorID=Auth::id();
         $this->models[0]->timeFrom()->save($time);
      }
   }
   public function go(Request $request)
   {
    return $this->create($request->all());
   }
   protected function denies($id=0)
   {
    return [Gate::denies('create-routes')];
   }
}
