<?php

namespace App\Http\Controllers\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use App\Http\Controllers\System\Response;
use Illuminate\Support\Facades\Auth;

class ActionEdit extends Controller
{
    protected $model=[],
              $models=[],
              $allow=[],
              $params=[];
    private $privileges=0;
    function __construct()
    {
     //
     $this->setModels();
    }
    //public function go(){}
  public function setModels()
  {
   $this->models[0]=app("App\Models".$this->model[0]);
  }
  protected function beforeEdit($id,&$params)
  {
   //
  }
  protected function afterEdit($id,&$params,&$arr)
  {
   //
  }
  protected function denies($id)
  {
   return [false,0];
  }
  protected function update($id,$arr=[])
  {
    $this->setModels();
    $denies=$this->denies($id);//Перевірка доступа
    if($denies[0])//
    {
     return Response::get(0,count($denies)>1?$denies[1]:0,'Немає привілеїв');//Повернення помилки доступу
    }

    $before=$this->beforeEdit($id,$arr);
    if($before&&!$before[0])
     {
        return Response::get($before[1],1,"Виникла помилка");
     }

    $this->privileges=app("App\Http\Controllers\Users\Privileges")->get();
    $result=[];
    $updateModel=$this->models[0]::find($id);

     if(!$updateModel)
     {
      return Response::get(101,1,'Виникла помилка');
     }
     $all_update=0;
     $old_value=[];
     foreach($arr as $name=>$value)//цикл параметрів
     {
      if(!array_key_exists($name,$updateModel::$filter))//Перевірка вірності вхідних полів
      {
       continue;
       return Response::get(1,1,'Виникла помилка');//Вивід помилки вірності вхідних полів
       //continue;
      }
      if(!isset($value)&&$value[0])//Первірка на Null значення полів
      {
         return Response::get(2,1,'Виникла помилка',$name." - ".$value);
      }
      if(is_array($updateModel::$filter[$name][1]))
      {
       if(!in_array($value,$updateModel::$filter[$name][1]))//Перевірка на вірність значень полів
       {
        return Response::get(3,1,'Виникла помилка');
       }
      }
      if($updateModel::$filter[$name][2]>$this->privileges)
      {
       return Response::get(4,1,'Виникла помилка',[$name,$updateModel::$filter[$name][3],$this->privileges]);
      }

      if(isset($updateModel::$createFunction)&&array_key_exists($name,$updateModel::$createFunction))
      {
       $value=$this->{$updateModel::$createFunction[$name]}($value);
      }

      $table=$name;//Отримання назви таблиці з полів

      if($updateModel[$table]==$value)
      {
       continue;
      }

      $old_value[$name]=$updateModel[$table];

      $updateModel[$table]=$value;

      $result[$name]=$value;
      }
      try
      {
       $updateModel->save();

       $keys=array_keys($result);

       $this->afterEdit($id,$arr,$keys);

       \App\Models\History\History::insert([
        "type"=>1,
        "old_value"=>json_encode($old_value, JSON_UNESCAPED_UNICODE),
        "new_value"=>json_encode($result, JSON_UNESCAPED_UNICODE),
        "authorID"=>Auth::id()
       ]);

       return Response::get(200,count($keys),$keys);
      }
      catch(\Exception $e)
      {
       return Response::get(102,1,'Виникла помилка',$e->getMessage());
      }
  }
}
