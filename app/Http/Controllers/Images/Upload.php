<?php

namespace App\Http\Controllers\Images;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\System\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Images\Images;

class Upload extends Controller
{
    public function save(Request $request)
    {
     return $this->saveImage($request);
    }
    private function saveImage($request)
    {
        // Validate (size is in KB)
        $validation = Validator::make($request->all(),['img'=>['required','file','image','dimensions:max_width=500,max_height=500']]);
        if ($validation->fails())
        {
         return Response::get(100,1,$validation->messages()->first());
        }
        // Read file contents...
        $contents = file_get_contents($request->img->path());

        // ...or just move it somewhere else (eg: local `storage` directory or S3)
        $newPath = $request->img->store('images');

        if(!$newPath)
        {
         return Response::get(101);
        }


        $img=new Images();
        $img->name=$request->img->getClientOriginalName();
        $img->url=$newPath;
        $img->urlIn=$newPath;
        $img->type=$request->img->extension();
        $img->authorID=Auth::id();
        $img->save();
        return Response::get(200,1,["id"=>$img->id,"url"=>$img->url,"name"=>$img->name]);
    }
}
