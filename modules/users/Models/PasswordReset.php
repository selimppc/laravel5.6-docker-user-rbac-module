<?php

namespace Modules\Users\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class PasswordReset extends Model
{
    protected $table = 'password_resets';

    protected $fillable = [
        'users_id',
        'email',
        'token',
        'expire_at'
    ];





}
