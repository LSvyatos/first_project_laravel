<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UsersAddress extends Model
{
    //
    protected $table="users_address";
    protected $hidden=['_delete','laravel_through_key','updated_at','created_at','active'];
}
