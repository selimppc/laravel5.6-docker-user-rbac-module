<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $fillable = [
        'title',
        'route_url',
        'description',
        #'created_by',
        #'updated_by'
    ];

    //TODO:: relations
    public function roles(){
        return $this->belongsToMany('Modules\User\Models\Role', 'roles_permissions', 'permissions_id',  'roles_id');
    }


    // TODO :: boot
   // boot() function used to insert logged user_id at 'created_by' & 'updated_by'
   public static function boot(){
       parent::boot();
       static::creating(function($query){
           if(Auth::check()){
               $query->created_by = @\Auth::user()->id;
           }
       });
       static::updating(function($query){
           if(Auth::check()){
               $query->updated_by = @\Auth::user()->id;
           }
       });
   }
}
