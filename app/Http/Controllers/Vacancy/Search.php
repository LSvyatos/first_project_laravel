<?php
namespace App\Http\Controllers\Vacancy;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionSearch;
use Illuminate\Support\Facades\Gate;
//use App\Models\Vacancy\Vacancy;

class Search extends ActionSearch
{
  protected $model=["\Vacancy\Vacancy","\Vacancy\Get"],
            $params=[
             "minYear"=>">=",
             "maxYear"=>"<=",
             "minPaymentSuma"=>">=",
             "maxPaymentSuma"=>"<="
            ];

  protected $filter=["city"];

  public function go(Request $request)
  {
   self::setParams($request->all());

   return self::get();
  }

  protected function denies($id=0)
  {
   return Gate::denies('search-vacancy');
  }
  protected function word(&$query)
  {
   $query->where('name','like','%'.$this->word.'%')
         ->orWhere('description','like','%'.$this->word.'%')
         ->orWhere('id','like','%'.$this->word.'%')
         ->orWhere('requirements','like','%'.$this->word.'%')
         ->orWhere('duties','like','%'.$this->word.'%')
         ->orWhere('schedule','like','%'.$this->word.'%')
         ->orWhere('text','like','%'.$this->word.'%')
         ->orWhereHas('city', function ($q)
          {
            $q->where('name', "like", "%".$this->word."%");
          })
         ->orWhereHas('category', function ($q)
          {
            $q->where('name', "like", "%".$this->word."%");
          });
  }
  protected function filter(&$arr)
  {
    if(array_key_exists('city',$this->filterValue))
    {
      $arr->whereHas('address', function ($q)
      {
         $q->where('cityID', $this->filterValue["city"]);
      });
    }
  }
  /*public function setParams($arr=[])
  {
    $this->word=array_key_exists("word",$arr)?$arr["word"]:Null;
    $this->typeSort=array_key_exists("sort",$arr)?$arr["sort"]:$this->typeSort;
    //$this->list_id=array_key_exists('id',$arr)?$arr['id']:[];
    $data=Vacancy::$data;
    foreach($arr as $key=>$val)
    {
     if(array_key_exists($key,$data))
     {
      $this->arr[$data[$key]]=$val;
     }
    }
  }
  public function getSearch()
  {
    if(Gate::denies('search-vacancy'))
    {
     return Response::get(0);
    }
    $result=Vacancy::select("id")->where('_delete',false);
    if(isset($this->word))
    {
     $result->where(function($query) {
          $query->where('name','like','%'.$this->word.'%')
                ->orWhere('desc','like','%'.$this->word.'%')
                ->orWhere('id','like','%'.$this->word.'%');
     });
    }

    foreach($this->arr as $key=>$val)
    {

      if(array_key_exists($key,$this->params))
      {
       $result->where($key,$this->params[$key],$val);
      }
      else
      {
       $result->where($key,$val);
      }

    }

    $ids=[];
    foreach($result->get() as $v)
    {
     array_push($ids,$v->id);
    }
    return Response::get(200,count($ids),$ids);
  }*/

}
?>
