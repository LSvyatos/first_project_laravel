<?php
namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionEdit;
use Illuminate\Support\Facades\Gate;

class Edit extends ActionEdit
{
  protected $model=["\Clients\Clients"];
  protected function afterEdit($id,&$params,&$arr)
  {
    $user=$this->models[0]->find($id);
   if(array_key_exists("phones",$params)&&count($params["phones"])>0)
   {

         foreach($params["phones"] as $key=>$value)
         {
          if(array_key_exists('id',$value))
          {
          $phone=$user->phones()->find($value["id"]);

          $phone->code=$value["code"];
          $phone->country=$value["country"];
          $phone->phone=$value["phone"];
          $phone->phoneFormat=$value["phoneFormat"];

          $phone->save();

          }
          else
          {
          $phones=app("\App\Models\Clients\ClientsPhones");

          $phones->code=$value["code"];
          $phones->country=$value["country"];
          $phones->phone=$value["phone"];
          $phones->phoneFormat=$value["phoneFormat"];
          $phones->authorID=1;
          $user->phones()->save($phones);

          }
         }
   }
   if(array_key_exists("deletePhones",$params)&&count($params["deletePhones"])>0)
   {
    $phonesDelete=app("\App\Http\Controllers\Clients\Phones\Delete");
    foreach($params["deletePhones"] as $key=>$value)
    {
     if(empty($value))
     {
       continue;
     }
     $res=$phonesDelete->go($value);
    }
   }
   if(array_key_exists('address',$params))
    {
     $newUAddress=app("\App\Models\Clients\ClientsAddress");

     $address=$user->address()->get();
     foreach($address as $val)
     {
       if(!in_array($val["cityID"],$params["address"]))
       {
        $user->address()->where('cityID',$val["cityID"])->delete();
       }
     }
     foreach($params["address"] as $key=>$val)
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
  public function go($id,Request $request)
  {
   return $this->update($id,$request->all());
  }
  protected function denies($id)
  {
    if(Gate::denies('edit-client'))
    {
     return [0];
    }
  }
}
?>
