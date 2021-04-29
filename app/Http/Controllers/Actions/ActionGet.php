<?php

namespace App\Http\Controllers\Actions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\System\Response;
use Illuminate\Support\Facades\Auth;

class ActionGet extends Controller
{
    protected $model=[],
              $allow=[],
              //$params=['id'=>1],
              $select=[],
              $models=[],
              $list_select=["id"],
              $key="id";
    protected function beforeGet($id)
    {
     //
    }
    protected function afterGet($id,&$model)
    {
     //
    }
    private $id=[],$privileges=0;
    public function __construct()
    {
      $this->models=[app("App\Models".$this->model[0])];
    }
    public function go($id)
    {
     $this->setId([$id]);
     return $this->get($id);
    }
    protected function denies($id)
    {
      return [false,0];
    }
    public function setSelect($arr=[])
    {
     $this->select=$arr;
    }
    protected function inFor(&$arr)
    {
     //
    }
    public function setId($arr=[])
    {
     $this->id=$arr[0];
    }
    public function get($id=0)
    {
      if($id>0)
      {
       $this->id=$id;
      }

      $denies=$this->denies($id);//Отримання даних про доступ

      if($denies[0])//Перевірка доступу
      {
       return Response::get(0,count($denies)>1?$denies[1]:0);//Вивід помилки про доступ
      }

      $this->beforeGet($id);//Викликл функції - перед

      $this->privileges=app("App\Http\Controllers\Users\Privileges")->get();//Отримання значення привілеїв

      $list_select=$this->list_select;//Отримання масиву даних які потрібно вивести

      foreach($this->select as $value)
      {
        /*if(!array_key_exists($key,$model::$data))
        {
         return Response::get(3);
        }*/

        if(isset($this->models[0]::$columnID)&&array_key_exists($value,$this->models[0]::$columnID))
        {
         $value=$this->models[0]::$columnID[$value];
        }

        if(!array_key_exists($value,$this->models[0]::$filter))
        {
         continue;
        }

        if($this->privileges<$this->models[0]::$filter[$value][2])
        {
         continue;
        }

        $column=$value;



         if(in_array($column,$list_select))
         {
          continue;
         }
         array_push($list_select,$column);

      }

      if(count($this->select)==0)
      {
       $getModel=$this->models[0]::find($this->id);
      }else
      {
       $getModel=$this->models[0]::select($list_select)
                                 ->find($this->id);
      }

      $this->inFor($getModel);
      $this->afterGet($id,$getModel);
      return Response::get(200,1,$getModel);
    }
}
