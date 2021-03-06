<?php

namespace App\Http\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
//use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

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
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function adminprovinsi() 
    {
        return $this->hasOne('App\Http\Models\AdminProvinsi', 'user_id');
    }

    public function operator()
    {
        return $this->hasMany('App\Http\Models\Operator', 'user_id');
    }

    public function apoteker()
    {
        return $this->hasMany('App\Http\Models\Apoteker', 'user_id');
    }

    public function admininstitusi()
    {
        return $this->hasMany('App\Http\Models\AdminInstitusi', 'user_id');
    }

    public function adminkabupaten()
    {
        return $this->hasMany('App\Http\Models\AdminKabupaten', 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Http\Models\Role');
    }

    public function assignRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
 
        return $this->roles()->attach($role);
    }
     
    public function revokeRole($role)
    {
        if (is_string($role)) {
            $role = Role::where('name', $role)->first();
        }
 
        return $this->roles()->detach($role);
    }
     
    public function hasRole($name)
    {
        foreach($this->roles as $role)
        {
            if ($role->name === $name) return true;
        }
         
        return false;
    }
}
