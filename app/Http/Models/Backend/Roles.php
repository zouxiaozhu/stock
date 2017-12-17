<?php
namespace App\Http\Models\Backend;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'roles';
    public $timestamps = true;


    public function scopeGetPrms($query, $role_ids)
    {
        return $query->leftJoin('role_auth', 'roles.id', '=', 'role_auth.role_id')->whereIn('roles.id', $role_ids)
            ->leftJoin('auths', 'role_auth.auth_id', '=', 'auths.id')->select('auths.name', 'auths.prm','auths.id')->orderBy('auths.id','ASC');
    }

}