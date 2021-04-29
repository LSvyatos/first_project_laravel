<?php
namespace App\Http\Controllers\Vacancy;

use Illuminate\Http\Request;
use App\Http\Controllers\Actions\ActionEdit;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;


class Edit extends ActionEdit
{
  protected $model=["\Vacancy\Vacancy"];

  protected function afterEdit($id,&$arr,&$params)
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

     $employers=$vacancy->employers()->get();

     foreach($employers as $val)
     {
       if(!in_array($val["userID"],$arr["employers"]))
       {
        $vacancy->employers()->where('userID',$val["userID"])->delete();
       }
     }
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
  public function go($id,Request $request)
  {
   return $this->update($id,$request->all());
  }
  protected function denies($id)
  {
    if(Gate::denies('edit-vacancy',Get::getAuthor($id)["id"]))
    {
     return [0];
    }
  }
}
?>
