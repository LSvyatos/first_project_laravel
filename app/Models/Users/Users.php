<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    protected $table="users";
    static public $data=array(
      "id"=>"id",
      "name"=>"name",
      "lastname"=>"lastname",
      "surname"=>"surname",
      "email"=>"email",
      "password"=>"password",
      "rememberToken"=>"remember_token",
      "role"=>"role",
      "author"=>"author",
      "text"=>"text",
      "active"=>"active"
    );
    static public $filter=array(
       "name"=>[0,6,6],
       "lastname"=>[0,6,6],
       "surname"=>[0,6,6],
       "email"=>[1,6,6],
       "password"=>[0,6,6],
       "role"=>[0,6,6],
       "text"=>[0,6,6],
       'authorID'=>[1,6,6]
    );
    static public $deleteEdit=['email'];
    static public $createFunction=['password'=>'generatorPassword'];
    static public $validationCreate=[
     'name'=>['required','min:1'],
     'lastname'=>['required','min:1'],
     //'email'=>['required','email'],
     //'password'=>['required','confirmed'],
     'role'=>['required','integer','between:2,6']
    ];

    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','email_verified_at','_delete','laravel_through_key','updated_at','created_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function address()
    {
        return $this->hasMany(UsersAddress::class,'userID','id');
    }
    public function phones()
    {
     return $this->hasMany(UsersPhones::class, 'clientID', 'id')->select(['id','phoneFormat as phone']);
    }
    public function getAddress()
    {
        return $this->hasManyThrough(
            \App\Models\Geography\City::class,
            UsersAddress::class,
            'userID',
            'id',
            'id',
            'cityID'
        );
    }
}
?>
