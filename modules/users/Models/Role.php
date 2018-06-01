<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = [
        'title',
        'slug',
        'status',
    ];


    //Relations
    public function users(){
        return $this->hasMany('App\User');
    }

    public function permissions()
    {
        #exit("OKOKOOKOKOKO");
        return $this->belongsToMany('Modules\User\Models\Permission', 'roles_permissions',  'roles_id', 'permissions_id');
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
