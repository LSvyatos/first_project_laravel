<?php

namespace App\Http\Controllers\Vacancy\Images;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;

class Get extends ActionGet
{
    //
    protected $model=['\Vacancy\VacancyImages'],
              $key="vacancy";
    protected function denies($id=0)
    {
     $gate=Gate::denies('get-vacancy-images');
     return [$gate];
    }
    public function go($id)//Клас для виклику з роутера
    {
      //return self::getImages(1);
      $res=$this->get($id);
      if($res["number"]>0)
      {
       $image=app("App\Http\Controllers\Images\Get");

        $img=$image->go($res["value"]["image"]);
        if($img["number"]>0)
        {
         $res["value"][$res["value"]["id"]]["url"]=$img["value"][0]["url"];
        }else{
         unset($res["value"][$key]);
        }

      }
      return $res;
    }
}
