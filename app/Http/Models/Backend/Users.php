<?php

namespace App\Http\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Users extends Model{
    protected $table = 'users';

    public function role()
    {
        return $this->belongsToMany('App\Models\Roles', 'user_role', 'user_id', 'role_id');
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->role->contains('prms',$role);
        }

        return $role->intersect($this->role)->count();
    }

    public function scopeIsAdmin(){
        return $user_id =auth()->user()->id ==1 ? 1 : 0 ;
    }

    public function getNameAttribute($value)
    {
        return $value;
    }

    public function setGetLastLoginAttribute($value)
    {

    }

    public static function getname()
    {

    }

}