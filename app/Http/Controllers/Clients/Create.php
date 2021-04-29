<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionCreate;
use Illuminate\Support\Facades\Gate;

class Create extends ActionCreate
{
   protected $model=["\Clients\Clients","\Clients\Search"];

   //private $access=0;
   protected function afterCreate($id,&$arr)
   {
    $user=$this->models[0]::find($id);
    if(array_key_exists("phones",$arr)&&count($arr["phones"])>0)
    {
     $mPhone=app("\App\Models\Clients\ClientsPhones");
     
     foreach($arr["phones"] as $key=>$value)
     {

      $phone=new $mPhone;
      $phone->code=$value["code"];
      $phone->country=$value["country"];
      $phone->phone=$value["phone"];
      $phone->phoneFormat=$value["phoneFormat"];
      $phone->authorID=1;
      $user->phones()->save($phone);
     }
    }
    if(array_key_exists('address',$arr))
    {
     $newUAddress=app("\App\Models\Clients\ClientsAddress");
     foreach($arr["address"] as $key=>$val)
     {
       $userAddress=$user->address()->where('cityID',$val)->first();
       if(empty($userAddress))
       {
         $new=new $newUAddress;
         $new->cityID=$val;
         $user->address()->save($new);
       }
     }
   }
   }
   public function go(Request $request)
   {
    $res=$this->create($request->all());
    if($res["status"]==200&&$res["value"]>0)
    {
     $get=app("\App\Http\Controllers\Clients\Get");
     $res["value"]=$get->get($res["value"])["value"];
    }
    return $res;
   }
   protected function denies($id=0)
   {
    return [Gate::denies('search-vacancy')];
   }
   public function Phones()
   {
    return app("\App\Http\Controllers\Clients\Phones\Create");
   }
}
