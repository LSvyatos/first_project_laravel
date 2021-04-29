<?php
namespace App\Http\Controllers\Vacancy;

use Illuminate\Http\Request;
use App\Http\Controllers\System\Response;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;

class Get extends ActionGet
{
  protected $model=["\Vacancy\Vacancy"];
  protected function denies($id)
  {
   return [Gate::denies('get-vacancy')];
  }
  protected function inFor(&$arr)
  {
   //$this->models=["\App\Models\Vacancy\VacancyImages"];
   $clients=app("App\Http\Controllers\Vacancy\Clients\Get");

   $arr["a_employers"]=$arr->employer()->get();

   $cls=$clients->get($arr["id"]);
   $arr->employersa;
   if(empty($this->select))
   {
    $arr->images;
   }

   if(isset($arr->categoryID))
   {
    $arr->category;
   }
   if(isset($arr->cityID))
   {
    $arr->city;
   }
   if(isset($arr->authorID))
   {
    $arr->author;
   }
  }
  public function go($id)//Клас для виклику з роутера
  {
   $this->setId([$id]);
   //return self::getImages(1);
   return $this->get();
  }


  /*static public function getResult($id=0)//Клас для отримання даних про вакансії
  {
   if(Gate::denies('get-vacancy'))
   {
    return Response::get(0);
   }
   if($id>0)
   {
    self::$id=$id;
   }
   $list_select=[];
   foreach(self::$params as $key=>$val)
   {
    array_push($list_select,Vacancy::$data[$key].' as '.$key);
   }
   $vacancy=Vacancy::select($list_select)->where('_delete',false)
                     ->whereIn("id",self::$id)
                     ->orderBy('id','desc')
                     //->limit(1)
                     ->get();
   $res=[];
   foreach($vacancy as $key=>$val)
   {

    $images=self::getImages($val->id);
    $clients=self::getClients($val->id);
    if($images["status"]==200)
    {
     $val->images=["number"=>$images["number"],"value"=>$images["value"]];
    }
    if($clients["status"]==200)
    {
     $val->clients=["number"=>$clients["number"],"value"=>$clients["value"]];
    }

   }
   return Response::get(200,count($vacancy),$vacancy->toArray());
  }
  static public function getCopy($id)//Клас для отрмання копїї вакансії
  {
   return Vacancy::where(['_delete'=>false,'id'=>$id])->orderBy('id','desc')->first()->replicate();
  }*/
  static public function getAuthor($id=0)//Клас для отримання автора вакансії
  {

     $result=app('App\Models\Vacancy\Vacancy')::select("authorID")->find($id);
     if($result)
     {
      return ["id"=>$result["authorID"]];
     }
     else
     {
      return ["id"=>0];
     }
     //return $result;
  }
  public function getClients($id=0)//Клас для отримання клієнтів вакансії
  {
     $model=app('App\Models\Vacancy\VacancyClients');
     $select=[
       $model::$data['client']
     ];

     if(Gate::denies('get-vacancy-clients'))
     {
      return ["status"=>0];
     }
     $result=VacancyClients::select($select)
                           ->where([$model::$data["vacancy"]=>$id,'active'=>1])
                           ->get();

     return Response::get(200,count($result),$result->toArray());

  }
  static public function getImages($id=0)//Клас для отримання забраження вакансії
  {
     $model=app('App\Models\Vacancy\VacancyImages');
     $select=[
      "id",
      $model::$data["name"],
      $model::$data["url"]
     ];
     $result=VacancyImages::select($select)
                          ->where(['vacancy'=>$id,'active'=>1])
                          ->get();
     return Response::get(200,count($result),$result->toArray());
  }
}
?>
