<?php
/**
 * Created by PhpStorm.
 * User: selimreza
 * Date: 01/06/18
 * Time: 4:03 PM
 */

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RolePermission extends Model
{

    protected $table = 'roles_permissions';

    protected $fillable = [
        'roles_id',
        'permissions_id',
        'status',
        'created_by',
        'updated_by',
    ];


    //TODO :: Relations
    public function relRole(){
        return $this->belongsTo('Modules\User\Models\Role', 'roles_id', 'id');
    }
    public function relPermission(){
        return $this->belongsTo('Modules\User\Models\Permission', 'permissions_id', 'id');
    }

    public function permissions()
    {
        return $this->belongsToMany('Modules\User\Models\Role', 'roles_permissions',
            'roles_id', 'permissions_id');
    }

    // TODO :: boot
    // boot() function used to insert logged user_id at 'created_by' & 'updated_by'
    public static function boot(){
        parent::boot();
        static::creating(function($query){
            if(Auth::check()){
                $query->created_by = \Auth::user()->id;
                $query->updated_by = \Auth::user()->id;
            }
        });
        static::updating(function($query){
            if(Auth::check()){
                $query->updated_by = \Auth::user()->id;
            }
        });
    }

}