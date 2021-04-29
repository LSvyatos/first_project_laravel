<?php
namespace App\Http\Controllers\Vacancy;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionCreate;
use Illuminate\Support\Facades\Auth;

class Create extends ActionCreate
{
   protected $model=["\Vacancy\Vacancy","\Vacancy\Search"];

   //private $access=0;
   protected function afterCreate($id,&$arr)
   {
    $mImages=app("\App\Models\Vacancy\VacancyImages");
    $vacancy=$this->models[0]::find($id);
    if(array_key_exists('listImage',$arr))
    {
      foreach($arr["listImage"] as $value)
      {
           $img=new $mImages;
           $img->imageID=$value;
           $img->authorID=Auth::id();
           $vacancy->image()->save($img);
       }
     }
     if(array_key_exists('employers',$arr))
     {
       $newVEmployer=app("\App\Models\Vacancy\VacancyEmployer");
       foreach($arr["employers"] as $key=>$val)
       {
         $vacancyEmployer=$vacancy->employers()->where('userID',$val)->first();
         if(empty($vacancyEmployer))
         {
           $new=new $newVEmployer;
           $new->userID=$val;
           $vacancy->employers()->save($new);
         }
       }
     }
   }
   public function go(Request $request)
   {
    return $this->create($request->all());
   }
   protected function denies($id=0)
   {
    return [Gate::denies('search-vacancy')];
   }
   /*private static function create($arr=[])
   {
     if (Gate::denies('create-vacancy'))
     {
      return ["status"=>0];
     }

     foreach(Vacancy::$filter as $key=>$value)
     {

      if(!array_key_exists($key,$arr) && $value[0])
      {
       return ["status"=>1];
      }
     }
     $new=[];

     $search=new \App\Http\Controllers\Vacancy\Search;
     $search->setParams($arr);
     $check=$search->getSearch();

     if(count($check)>0)
     {
      return ["status"=>2];
     }

     foreach($arr as $key=>$value)
     {
       $k=Vacancy::$data[$key];

       $new[$k]=$value;
     }
     $new["author"]=Auth::id();
     $result=Vacancy::insert($new);
     if($result)
     {
       return ["status"=>200,"value"=>$result];
     }
     return ["status"=>3];
   }*/
}
?>
