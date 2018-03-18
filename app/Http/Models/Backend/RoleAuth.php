<?php
namespace App\Http\Models\Backend;
use Illuminate\Database\Eloquent\Model;

class RoleAuth extends Model{

    protected $table = 'role_auth';
    public $timestamps = true;
    protected $guarded = [];
    protected $dateFormat = 'U';

}