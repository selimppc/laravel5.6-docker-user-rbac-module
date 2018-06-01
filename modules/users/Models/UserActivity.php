<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserActivity extends Model
{
    /**
     * @var string
     */
    protected $table = 'users_activitys';

    /**
     * @var array
     */
    protected $fillable = [
        'market_place_id',
        'ip_address',
        'action_name',
        'action_url',
        'action_detail',
        'action_table',
        'users_id'
    ];

    //relations
    /*
     * Object relational mapping
    */
    public function relUsers(){
        return $this->hasMany('App\User', 'id', 'users_id' );
    }

    public function relUser(){
        return $this->hasOne('App\User', 'id', 'users_id' );
    }

    public function relMarketPlace(){
        return $this->hasOne('Modules\Product\Models\MarketPlace', 'id', 'market_place_id' );
    }

    //scopes


    // TODO :: boot
    // boot() function used to insert logged user_id at 'created_by' & 'updated_by'
    public static function boot(){
        parent::boot();
        static::creating(function($query){
            if(Auth::check()){
                $query->users_id = @Auth::user()->id;
            }
        });
    }



}
