<?php

namespace App\Http\Controllers\Actions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\System\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ActionCreate extends Controller
{
    protected $model=[],
              $models=[],
              $allow=[],
              $params=[];
    private $privileges=0;
    protected function beforeCreate(&$params)
    {
     //
    }
    protected function afterCreate($id,&$params)
    {
     //
    }
    public function __construct()
    {
     $this->models[0]=app("\App\Models".$this->model[0]);
     $this->models[1]=app("\App\Http\Controllers".$this->model[1]);
    }
    protected function denies($id=0)
    {
     return [false,0];
    }
    public function create($arr)
    {
     $paramsSearch=[];

     $denies=$this->denies();//Перевірка прівілеїв

     if($denies[0])//Перевірка прівілеїв
     {
      return Response::get(0,1,"Немає привілеїв");//Вивід помилки привілеїв
     }

     $this->privileges=app("App\Http\Controllers\Users\Privileges")->get();
     //$new=[];

     $before=$this->beforeCreate($arr);

     if($before&&!$before[0])
     {
        return Response::get($before[1],1,"Виникла помилка");
     }

     $model=$this->models[0];//Отримання моделі

     $validator=Validator::make($arr, $model::$validationCreate);

     if($validator->fails())
     {
      return Response::get(10,1,"Не всі поля заповнені вірно",$validator);
     }

     foreach($arr as $key=>$value)
     {
       if(!isset($value))
       {

        if($value[0])
        {
         return Response::get(3,1,"Виникла помилка");
        }
        else
        {
         continue;
        }

       }

       if(!array_key_exists($key,$model::$filter))
       {
        continue;
       }

       if($model::$filter[$key][0])
       {
        $paramsSearch[$key]=$value;
       }

       if(isset($model::$createFunction)&&array_key_exists($key,$model::$createFunction))
       {
        $value=$this->{$model::$createFunction[$key]}($value);
       }

       $model[$key]=$value;//Присвоєння полю данних
     }

     $search=$this->models[1];
     $search->setParams(["filter"=>$paramsSearch]);
     $check=$search->getResult();
     if($check["status"]==200&&count($check["value"])>0)
     {
      return Response::get(100,1,"Виникла помилка: Дублювання запису");
     }
     $model["authorID"]=Auth::id();
     $model->save();
     try
      {
       $model->save();

       if(!$model->id)
       {
        return Response::get(4,1,"Виникла помилка");
       }

       $this->afterCreate($model->id,$arr);
       \App\Models\History\History::insert([
        "type"=>0,
        "new_value"=>json_encode($arr, JSON_UNESCAPED_UNICODE),
        "authorID"=>Auth::id()
       ]);
       return Response::get(200,1,$model->id,$model);
      }
      catch(\Exception $e)
      {
       return Response::get(101,1,"Виникла помилка",$e->getMessage());
      }

    }
}
