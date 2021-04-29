<?php

namespace App\Models\Transport;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $table="transport";
    protected $hidden=['_delete'];
    static public $data=array(
      "id"=>"id",
      "name"=>"name",
      "number"=>"number",
      "author"=>"author",
      "placeFrom"=>"place_from",
      "placeTo"=>"place_to",
      "type"=>"type",
      "dataNextTeh"=>"data_nast_tex",
      "dataNextGreenCard"=>"data_nast_zel_karty",
      "dataNextBorderCrossing"=>"data_nast_per_kordonu",
      "text"=>"text",
      "active"=>"active"
    );
    static public $filter=array(
         "name"=>[1,6,6],
         "number"=>[1,6,6],
         "placeTo"=>[1,6,6],
         "placeFrom"=>[1,6,6],
         "type"=>[1,6,6],
         "dataNextTeh"=>[0,6,6],
         "dataNextGreenCard"=>[0,6,6],
         "dataNextBorderCrossing"=>[0,6,6],
         "text"=>[0,6,6],
         'authorID'=>[1,6,6]
    );
    static public $validationCreate=[
     'name'=>['required'],
     'number'=>['required'],
     'placeFrom'=>['required'],
     'placeTo'=>['required'],
     'type'=>['required']
    ];
    public function About()
    {
     return TransportAbout::class;
    }
    public function Perhaps()
    {
     return TransportPerhaps::class;
    }
    public function Position()
    {
     return TransportPosition::class;
    }
    public function State()
    {
     return TransportState::class;
    }
    public function author()
    {
     return $this->belongsTo(\App\Models\Users\Users::class,'authorID','id');
    }
}
