<?php
namespace App\Http\Controllers\Tickets;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionCreate;
use App\Http\Controllers\System\Response;
use Illuminate\Foundation\Console\Presets\React;
use Illuminate\Support\Facades\Auth;

class Create extends ActionCreate
{
   protected $model=["\Tickets\Tickets","\Tickets\Search"];

   //private $access=0;
   protected function beforeCreate(&$arr)
   {

    $clientID=array_key_exists('clientID',$arr)?$arr['clientID']:0;
    $lastname=array_key_exists("lastname",$arr)?$arr["lastname"]:"";
    $name=array_key_exists("name",$arr)?$arr["name"]:"";
    $surname=array_key_exists("surname",$arr)?$arr["surname"]:"";

    if(!array_key_exists('fromID',$arr) ||
       !array_key_exists('toID',$arr) ||
       !array_key_exists('tripID',$arr) ||
       !array_key_exists('perhapID',$arr) ||
       $arr["fromID"]==0 ||
       $arr["toID"]==0
    )
    {
       return [false,119];
    }
    if(empty($arr["timeFrom"]))
    {
       $arr["timeFrom"]="00:00";
    }
    $client=$this->models[0]->Clients()::where(['id'=>$clientID])
                                         ->orWhere(
                                            function($query) use ($name,$lastname,$surname){
                                               $query->where('name',$name);
                                               $query->where('lastname',$lastname);
                                               $query->where('surname',$surname);
                                            }
                                         )
                                          ->first();

    if(empty($client))
    {
       if($lastname=="" && $name=="" && $surname=="")
       {
          return [false,120];
       }
       $clientNew=app('\App\Http\Controllers\Clients\Create')->create([
          'name'=>$name,
          'lastname'=>$lastname,
          'surname'=>$surname
       ]);
       $client=$clientNew["params"];       
    }
      
    $arr["clientID"]=$client->id;
   
    $arr["clientText"]=$client->lastname." ".$client->name." ".$client->surname;

    $trip=$this->models[0]->Trips()::where('id',$arr['tripID'])->first();

    if(empty($trip))
    {
       return [false,121];
    }

    $arr["transportID"]=$trip["transportID"];
    $checkPerhap=$this->models[0]->mPerhaps()::where([
      'id'=>$arr["perhapID"]
      ])->first();
   if(!empty($checkPerhap)&&$checkPerhap["ticketID"]!=0)
   {
      return [false,122];
   }   
    
    $dateFrom=strtotime($trip["timeFrom"]);

    //$arr["timeFrom"]=$trip["timeFrom"];

    $route=$this->models[0]->Routes()::where(['routeID'=>1,'fromID'=>$arr['fromID'],'toID'=>$arr['toID']])->first();

    $currency=\App\Models\Data\Currency::find(array_key_exists("currencyID",$arr)?$arr['currencyID']:0);

    if(empty($currency))
    {
       return [false,123];
    }

    if(empty($route))
    {
      $routeNew=app('\App\Http\Controllers\Routes\Children\Create')->create([
         'fromID'=>$arr["fromID"],
         'toID'=>$arr["toID"],
         'routeID'=>$trip["routeID"],
         'price'.$currency["value"]=>$arr['price'],
         'timeFrom'=>$arr["timeFrom"]
      ]);
      $route=$routeNew["params"];
    }
    if(array_key_exists('timeFrom',$arr))
    {
      $dateFrom=$dateFrom+strtotime($arr["timeFrom"])-strtotime('TODAY');
    }

    $arr["timeFrom"]=date("Y-m-d H:i:s",$dateFrom);

    $arr["routeID"]=$route->id;
    return [true];
   }
   protected function afterCreate($id,&$arr)
   {
    $this->models[0]->perhap()->first()->update(['ticketID'=>$id]);
   }
   public function go(Request $request)
   {
    return $this->create($request->all());
   }
   protected function denies($id=0)
   {
    return [Gate::denies('create-tickets')];
   }
}
