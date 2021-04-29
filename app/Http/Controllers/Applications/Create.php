<?php

namespace App\Http\Controllers\Applications;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionCreate;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\System\Response;

class Create extends ActionCreate
{
   protected $model=["\Applications\Applications","\Applications\Search"];

   //private $access=0;

   protected function beforeCreate(&$arr)
   {
    if(!array_key_exists('client',$arr)||$arr['client']==0)
    {
     $user=[
      'name'=>array_key_exists('name',$arr)?$arr['name']:'',
      'lastname'=>array_key_exists('lastname',$arr)?$arr['lastname']:'',
      'surname'=>array_key_exists('surname',$arr)?$arr['surname']:'',
     ];
     $model=app("App\Http\Controllers\Clients\Create");
     $idUser=$model->create($user);
     if($idUser['status']!==200||$idUser['value']<=0)
     {
      return Response::get(110,1,$idUser);
     }
     $arr['client']=$idUser['value'];
    }
   }

   public function go(Request $request)
   {
    return $this->create($request->all());
   }
   protected function denies($id=0)
   {
    return [Gate::denies('search-applications')];
   }
}
