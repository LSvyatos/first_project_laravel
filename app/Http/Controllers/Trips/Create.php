<?php
namespace App\Http\Controllers\Trips;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionCreate;
use Illuminate\Support\Facades\Auth;

class Create extends ActionCreate
{
   protected $model=["\Trips\Trips","\Trips\Search"];

   public function beforeCreate(&$arr)
   {

    $route=$this->models[0]->mRoute()::find($arr["routeID"]);
    $arr["fromID"]=$route["fromID"];
    $arr["toID"]=$route["toID"];

    return [true];
   }
   protected function afterCreate($id,&$arr)
   {
    $trip=$this->models[0]::find($id);
   if(array_key_exists('drivers',$arr))
    {
     $newUTrips=app("\App\Models\Trips\TripsDrivers");


     foreach($arr["drivers"] as $val)
     {
       $userTrips=$trip->drivers()->where('userID',$val)->first();
       if(empty($userTrips))
       {
         $new=new $newUTrips;
         $new->userID=$val;
         $trip->drivers()->save($new);
       }
     }
   }


    $from=array_key_exists("perhapFrom",$arr)?($arr["perhapFrom"]>0?$arr["perhapFrom"]:1):1;
    $to=array_key_exists("perhapTo",$arr)?($arr["perhapTo"]>0?$arr["perhapTo"]:50):50;
    $new=[];
    for(;$from<=$to;$from++)
    {
     $new[]=[
      "transportID"=>$arr["transportID"],
      "perhap"=>$from,
      "tripID"=>$id,
      "ticketID"=>0
     ];
    }
    $this->models[0]->Perhaps()::insert($new);
   }
   //private $access=0;
   public function go(Request $request)
   {
    return $this->create($request->all());
   }
   protected function denies($id=0)
   {
    return [Gate::denies('search-trips')];
   }
}
