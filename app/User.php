<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Authenticatable implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Notifiable, Authorizable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    //check permission
    /**
     * @param null $permission
     * @return bool
     */
    public function can_access($permission = null){

        return !is_null($permission)  && $this->checkPermission($permission);
    }

    //check if the permission matches with any permission user has
    /**
     * @param $perm
     * @return array
     */
    protected function checkPermission($perm){

        $permissions = $this->getAllPermissionFromAllRoles();

        $permissionArray = is_array($perm) ? $perm : [$perm];
        return array_intersect($permissions, $permissionArray);


    }

    //Get All permission slugs from all permission of all roles
    /**
     * @return array
     */
    protected function getAllPermissionFromAllRoles(){

        $permissionsArray = array();
        $permissions = $this->relRole->load('permissions')->toArray();

        foreach ($permissions as $vales){
            $permissionsArray = array_merge($permissionsArray, $vales['permissions']);
        }

        $permissions = $permissionsArray; // make the array into $permissions

        return array_map('strtolower', array_unique(array_flatten(array_map(function($permission){
            return array_pluck(array($permission), 'route_url');
        }, $permissions))));


    }

    /*
     * Object relational mapping
    */
    public function relRole()
    {
        return $this->belongsToMany('\Modules\User\Models\Role', 'roles_users', 'users_id','roles_id' );
    }

    //Relations
    public function relProfile(){
        return $this->belongsTo('Modules\Web\Models\UsersProfiles', 'id', 'users_id');
    }

    public function relCustomerGroup(){
        return $this->belongsTo('Modules\Customer\Models\CustomerGroup', 'customer_group_id', 'id');
    }

    public function relGiftCardCode(){
        return $this->hasOne('Modules\Giftcommission\Models\GiftCardCode', 'id', 'gift_card_code_id');
    }

    public function relGiftCard(){
        return $this->hasOne('Modules\Giftcommission\Models\GiftCard', 'id', 'gift_card_id');
    }

    public function relBilling(){
        return $this->hasMany('Modules\Web\Models\UsersBillingShipping', 'users_id', 'id')->where('type','billing');
    }

    public function relShipping(){
        return $this->hasMany('Modules\Web\Models\UsersBillingShipping', 'users_id', 'id')->where('type','shipping');
    }

    public function relUsersRxDoc(){
        return $this->hasMany('Modules\Web\Models\UsersRxDoc', 'users_id', 'id');
    }



    // get role
    /**
     * @param $role_id
     * @return bool
     */
    public static function getRole($role_id)
    {
        if(Auth::check())
        {
            $role = Role::where('id', $role_id)->first();
            $data = $role['slug'];
            return $data;
        }else{
            return false;
        }
    }


    // TODO :: boot
    // boot() function used to insert logged user_id at 'created_by' & 'updated_by'
    public static function boot(){
        parent::boot();
        static::creating(function($query){
            if(Auth::check()){
                $query->created_by = Auth::user()->id;
                $query->updated_by = null;
            }
        });
        static::updating(function($query){
            if(Auth::check()){
                $query->updated_by = Auth::user()->id;
            }
        });
    }


    //TODO:: Setter and Getter
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst($value);
    }
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst($value);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /* public function getUsernameAttribute($value)
     {
         #return strtok($value, '@');
     }*/
}
