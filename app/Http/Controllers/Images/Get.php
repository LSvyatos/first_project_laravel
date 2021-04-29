<?php

namespace App\Http\Controllers\Images;

use Illuminate\Http\Request;
use Storage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Actions\ActionGet;

class Get extends ActionGet
{
  protected $model=["\Images\Images"];
    public function go($id)//Клас для виклику з роутера
    {
      $this->setId([$id]);
      return $this->get();
    }
    public function displayImage($filename)

    {
     $path = storage_path('app/images/' . $filename);

     if (!File::exists($path)) {
        abort(404);
     }
     $file = File::get($path);
     $type = File::mimeType($path);

     $response = \Response::make($file, 200);
     $response->header("Content-Type", $type);
     return $response;
    }
}
