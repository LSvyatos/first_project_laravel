<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UsersPrivileges extends Model
{
    protected $table="users_privileges";
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
    static public $data=array(
      "id"=>"id",
      "user"=>"user",
      "privilege"=>"privilege"
    );
    static public $filter=array(
       "user"=>[1,false,6,6],
       "privilege"=>[1,false,6,6]
    );
}
?>
