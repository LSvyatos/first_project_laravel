<?php
namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionCreate;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class Create extends ActionCreate
{
   protected $model=["\Users\Users","\Users\Search"];

   //private $access=0;
   public function beforeCreate(&$arr)
   {
       if(!array_key_exists('email',$arr)||$arr["email"]=="")
       {
           $arr["email"]="user".rand(1000,9999)."@zuzo.biz";
       }
       if(!array_key_exists('password',$arr)||$arr["password"]=="")
       {
           $arr["password"]=$arr["email"];
       }
   }
   public function afterCreate($id,&$arr)
   {
    $user=$this->models[0]::find($id);
    if(array_key_exists("phones",$arr)&&count($arr["phones"])>0)
    {
     $mPhone=app("\App\Models\Users\UsersPhones");
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
     $newUAddress=app("\App\Models\Users\UsersAddress");
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
   public function generatorPassword($val)
   {
    return Hash::make($val);
   }
   public function go(Request $request)
   {
   $params=$request->all();
   $res=$this->create($params);
       return $res;
   /*if(array_key_exists("password",$params)||array_key_exists("confirmPassword",$params))
      {
          if(!array_key_exists("password",$params)||!array_key_exists("confirmPassword",$params))
          {
           return Response::get(6);
          }
          if($params["password"]!=$params["confirmPassword"])
          {
           return Response::get(5);
          }
          $params["password"]=Hash::make($params["password"]);
      }*/
    unset($params["confirmPassword"]);
    $res=$this->create($params);
    return $res;
   }
   protected function denies($id=0)
   {
    return [Gate::denies('create-users')];
   }
}
