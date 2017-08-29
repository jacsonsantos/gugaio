<?php
namespace JSantos\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';

    public function roles()
    {
        return $this->belongsToMany("JSantos\Model\Role","user_role","user_id","role_id");
    }
}