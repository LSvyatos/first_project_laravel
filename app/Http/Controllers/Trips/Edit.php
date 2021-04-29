<?php
namespace App\Http\Controllers\Trips;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionEdit;
use Illuminate\Support\Facades\Gate;

class Edit extends ActionEdit
{
  protected $model=["\Trips\Trips"];



  protected function afterEdit($id, &$params, &$arr)
  {
    if(array_key_exists('drivers',$params))
    {
     $newUTrips=app("\App\Models\Trips\TripsDrivers");

     $trip=$this->models[0]::find($id);
     $drivers=$trip->drivers()->get();
     foreach($drivers as $val)
     {
       if(!in_array($val["userID"],$params["drivers"]))
       {
        $trip->drivers()->where('userID',$val)->delete();
       }
     }
     foreach($params["drivers"] as $val)
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
  }

  public function go($id,Request $request)
  {
   return $this->update($id,$request->all());
  }
  protected function denies($id)
  {
    if(Gate::denies('edit-trips'))
    {
     return [0];
    }
  }
}
