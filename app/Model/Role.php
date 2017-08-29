<?php
namespace JSantos\Model;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "role";

    public function users()
    {
        return $this->belongsToMany("JSantos\Model\User","user_role","role_id","user_id");
    }
}