<?php

namespace App\Http\Controllers\Clients;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionGet;
use App\Http\Controllers\System\Response;
use Illuminate\Support\Facades\Gate;
//use App\Models\Clients\Clients;
//use App\Models\Clients\ClientsAddress;
//use App\Models\Clients\ClientsMessenger;
//use App\Models\Clients\ClientsPhones;

class Get extends ActionGet
{
    protected $model=["\Clients\Clients"];

    public function go($id)
    {
     return $this->get($id);
    }
    protected function inFor(&$arr)
    {
      $arr["a_address"]=$arr->getAddress()->get();
      if(empty($this->select)||in_array("messenger",$this->select))
      {
       $arr->messenger;
      }
      if(empty($this->select)||in_array("phones",$this->select))
      {
       $arr->phones;
      }
    }
    /*static public function getResult($id=0)
    {
      if(Gate::denies('get-clients'))
      {
       return Response::get(0);
      }

      if($id==0)
      {
       $id=self::$ids;
      }else{
       $id=[$id];
      }

      $select=[];
      foreach(self::$select as $val)
      {
       $select[]=Clients::$data[$val];
      }
      $get=Clients::select($select)
                  ->whereIn('id',$id)
                  ->where(['_delete'=>false])
                  ->get();
      foreach($get as $val)
      {
       $address=self::getAddress($val->id);
       $messenger=self::getMessenger($val->id);
       $phones=self::getPhones($val->id);
       if($address["status"]==200)
       {
        $val->address=["number"=>$address["number"],"value"=>$address["value"]];
       }
       if($messenger["status"]==200)
       {
        $val->messenger=["number"=>$messenger["number"],"value"=>$messenger["value"]];
       }
       if($phones["status"]==200)
       {
        $val->phones=["number"=>$phones["number"],"value"=>$phones["value"]];
       }
      }
      return Response::get(200,count($get),$get);
    }
    static public function getAddress($id)
    {
      if(Gate::denies('get-clients-address'))
      {
       return ["status"=>0];
      }

      $res=ClientsAddress::select("city","name")
                           ->where(['client'=>$id,'active'=>1])
                           ->get();
      return Response::get(200,count($res),$res);
    }
    static public function getMessenger($id)
    {
      if(Gate::denies('get-clients-messenger'))
      {
       return Response::get(0);
      }
      $res=ClientsMessenger::select("messenger")
                           ->where(['client'=>$id,'active'=>1])
                           ->get();
      return Response::get(200,count($res),$res);
    }
    static public function getPhones($id)
    {
      if(Gate::denies('get-clients-phones'))
      {
       return Response::get(0);
      }
      $res=ClientsPhones::select("code","country","phone","phone_format")
                           ->where(['client'=>$id,'active'=>1])
                           ->get();
      return Response::get(200,count($res),$res);
    }*/
}
