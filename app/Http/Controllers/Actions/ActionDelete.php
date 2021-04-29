<?php

namespace App\Http\Controllers\Actions;

use Illuminate\Http\Request;
use App\Http\Controllers\System\Response;
use App\Http\Controllers\Vacancy\Get;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Trash\Trash;

class ActionDelete extends Controller
{
    protected $model=[],
              $models=[],
              $allow=[],
              $params=[];
    protected function after($id,&$arr)
    {
     //
    }
    private $privileges=0;
    public function __construct()
    {
      $this->models=[app("App\Models".$this->model[0])];
    }
    public function go($id)
    {
     return self::setDelete($id);
    }
    public function goUdelete($id)
    {
     return self::udelete($id);
    }
    protected function denies($id=0)
    {
     return [false,0];
    }
    private function setDelete($id)
    {


     //$model=self::$models[0];
     if(!$this->models[0])
     {
      return Response::get(1);
     }
     $denies=$this->denies($id);
     if($denies[0])
     {
      return Response::get(0);
     }

     $this->privileges=app("App\Http\Controllers\Users\Privileges")->get();

     $model=$this->models[0];

     $deleteModel=$model::find((int)$id);

       \App\Models\History\History::insert([
        "type"=>2,
        "old_value"=>json_encode(["_delete"=>0]),
        "new_value"=>json_encode(["_delete"=>1]),
        "authorID"=>Auth::id()
       ]);

     Trash::insert([
      "column_name"=>$this->model[0],
      "value"=>json_encode($deleteModel,JSON_UNESCAPED_UNICODE),
      "authorID"=>Auth::id(),
      "active"=>1
     ]);
     if(!$deleteModel)
     {
      return Response::get(2);
     }
     $this->after($id,$deleteModel);
     $deleteModel->delete();


     return Response::get(200,1,$deleteModel==true);
    }
    private function setUDelete($id)
    {
     if(!class_exists($this->models[0]))
     {
      return Response::get(1);
     }
     $denies=$this->denies($id);
     if($denies[0])
     {
      return Response::get(0);
     }

     $this->privileges=app("App\Http\Controllers\Users\Privileges")->get();

     $model=$this->models[0];

     $deleteModel=$model::find((int)$id);
     if($deleteModel->_delete)
     {
      $deleteModel->_delete=false;
     }
     $deleteModel->save();
       \App\Models\History\History::insert([
        "type"=>2,
        "old_value"=>json_encode(["_delete"=>1]),
        "new_value"=>json_encode(["_delete"=>0]),
        "authorID"=>Auth::id()
       ]);
     if(!$deleteModel)
     {
        return Response::get(2);
     }
     return Response::get(200,1,$deleteModel==true);
    }
}
