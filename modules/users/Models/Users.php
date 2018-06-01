<?php

namespace Modules\Users\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Support\Facades\Auth;

class Users extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username','email','password','auth_key','access_token','csrf_token','ip_address','last_visit','expire_date','remember_token','company_id','role_id','department_id','status','created_by'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    //check permission
    public function can_access($permission = null){

        return !is_null($permission)  && $this->checkPermission($permission);
    }

    //check if the permission matches with any permission user has
    protected function checkPermission($perm){
        $permissions = $this->getAllPermissionFromAllRoles();
        $permissionArray = is_array($perm) ? $perm : [$perm];

        return array_intersect($permissions, $permissionArray);
    }


//Get All permission slugs from all permission of all roles

    protected function getAllPermissionFromAllRoles(){
        $permissionsArray = [];
        $permissions = $this->relRole->load('permissions')->fetch('permissions')->toArray();

        return array_map('strtolower', array_unique(array_flatten(array_map(function($permission){
            return array_pluck($permission, 'route_url');

        }, $permissions))));
    }

/*This function only used for getting role information*/
    public function relRoleInfo(){
        return $this->belongsTo('App\Role', 'role_id', 'id');
    }

    public function relRole(){
        return $this->belongsToMany('App\Role');
    }

    public static function getRole($user_id){
        $role=User::join('role_user','user.id','=','role_user.user_id')
            ->join('role','role_user.role_id','=','role.id')
            ->where('user.id',$user_id)
            ->select('role.id','role.slug')
            ->get();
        return $role;
    }
    public function relDepartment(){
        return $this->belongsTo('App\Department', 'department_id', 'id');
    }
    public function relCompany(){
        return $this->belongsTo('App\Company', 'company_id', 'id');
    }

    // TODO :: boot
   // boot() function used to insert logged user_id at 'created_by' & 'updated_by'

    public static function boot(){
        parent::boot();
        static::creating(function($query){
            if(Auth::check()){
                $query->created_by = Auth::user()->id;
            }
        });
        static::updating(function($query){
            if(Auth::check()){
                $query->updated_by = Auth::user()->id;
            }
        });
    }
}
