<?php
/**
 * Created by PhpStorm.
 * User: Mithun Adhikary
 * Date: 3/14/17
 * Time: 7:34 PM
 */

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RoleUser extends Model
{

    protected $table = 'roles_users';
    protected $fillable = [
        'roles_id',
        'users_id',
        'remember_token',
        'status',
        'created_by',
        'updated_by'
    ];

    public function relRole(){
        return $this->belongsTo('Modules\User\Models\Role', 'roles_id', 'id');
    }
    public function relUser(){
        return $this->belongsTo('App\User', 'users_id', 'id');
    }

    // TODO :: boot
    // boot() function used to insert logged user_id at 'created_by' & 'updated_by'

    public static function boot(){
        parent::boot();
        static::creating(function($query){
            if(Auth::check()){
                $query->created_by = @Auth::user()->id;
            }
        });
        static::updating(function($query){
            if(Auth::check()){
                $query->updated_by = @Auth::user()->id;
            }
        });
    }

}