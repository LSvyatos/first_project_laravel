<?php

namespace App\Http\Controllers\Actions;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\System\Response;

class ActionSearch extends Controller
{
  protected $model=[],
            $models=[];
  protected $word=Null,
            $words=Null,

          $paramsSortDirection=['desc','asc'],
          $paramsSortColumn=['id'],
          $sort=[
           "page"=>1,
           "max"=>20,
           "sort"=>0,
           "sortBy"=>"id",
           "direction"=>"desc"
          ],
          $select=null,
          $arr=["active"=>1],
          $params=[];
  protected $filter=[],
            $filterValue=[];        
  protected function beforeSearch(&$arr)
  {
   //
  }
  protected function beforeGet(&$arr,&$res)
  {
   //
  }
  protected function word(&$arr)
  {
   //
  }
  private $privileges=0;
  public function __construct()
  {
   $this->models[0]="App\Models".$this->model[0];
   $this->models[1]="App\Http\Controllers".$this->model[1];
  }
  protected function denies($id=0)
  {
    return false;
  }

  protected function join(&$join)
  {
   //
  }

  protected function filter(&$arr)
  {
    //
  }

  public function setParams($arr=[])
  {
    if(array_key_exists("select",$arr))
    {
     $this->select=$arr["select"];
    }
    $this->words=array_key_exists("word",$arr)?$arr["word"]:Null;
    $this->sort["max"]=array_key_exists("numberPage",$arr)?$arr["numberPage"]:$this->sort["max"];
    $this->sort["page"]=array_key_exists("page",$arr)?$arr["page"]:$this->sort["page"];
    $this->sort["sortBy"]=array_key_exists("sortBy",$arr)?$arr["sortBy"]:'id';
    $this->sort['direction']=array_key_exists("direction",$arr)?$arr["direction"]:'desc';
    //$this->list_id=array_key_exists('id',$arr)?$arr['id']:[];
    $data=app($this->models[0])::$filter;
    if(array_key_exists("filter",$arr))
    {
    foreach($arr["filter"] as $key=>$val)
    {
     if(array_key_exists($key,$data))
     {
      $this->arr[$key]=$val;
     }else if(in_array($key,$this->filter))
     {
       $this->filterValue[$key]=$val;
     }
    }
    }
  }
  public function getResult($params=[])
  {
   if(count($params)>0)
   {
    $this->setParams($params);
   }
   if($this->denies())
   {
    return Response::get(0);
   }

   $this->beforeSearch($this->arr);

   $this->privileges=app("App\Http\Controllers\Users\Privileges")->get();


   $result=app($this->models[0])::select("id");

    if(isset($this->words))
    {
     $words=explode(" ",$this->words);
     foreach($words as $value)
     {
      $this->word=$value;
      $result->where(function($query){$this->word($query);});
     }
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
    if(count($this->filterValue)>0)
    {
      $this->filter($result);
    }

    $from=$this->sort["max"]*($this->sort["page"]>0?(int)$this->sort["page"]-1:0);
    $max=($this->sort["max"]);
    $count=$result->count();

    $result->skip($from);
    $result->take($max);

    if(isset($this->sort["sortBy"])){
    $result->orderBy(
      in_array($this->sort["sortBy"],$this->paramsSortColumn)?$this->sort["sortBy"]:"id",
      in_array($this->sort["direction"],$this->paramsSortDirection)?$this->sort["direction"]:"desc",
    );
    }

    $ids=[];
    $this->sort["page"];

    $this->beforeGet($this->arr,$result);

    $res=$result->get();
    foreach($res as $v)
    {
     array_push($ids,$v->id);
    }
    return Response::get(200,count($ids),$ids,["number"=>$count,"page"=>$this->sort["page"]]);
  }
  public function get($params=[])
  {
   $id_result_search=$this->getResult($params);
   if($id_result_search["status"]!=200||$id_result_search["number"]<=0)
   {
    return $id_result_search;
   }
   $res=[];
   $new=app($this->models[1]);

   if(isset($this->select))
   {
    $new->setSelect($this->select);
   }

   foreach($id_result_search["value"] as $id)
   {
    $res[]=$new->get($id)["value"];
   }
   //print_r($res);
   $result["status"]=200;
   $result["number"]=count($res);
   $result["value"]=$res;
   $result["all"]=$id_result_search["params"]["number"];
   $result["page"]=$id_result_search["params"]["page"];
   return $result;
  }
}
