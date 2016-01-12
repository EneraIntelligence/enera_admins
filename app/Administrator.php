<?php

namespace Admins;

use Jenssegers\Mongodb\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Administrator extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database collection used by the model.
     *
     * @var string
     */
    protected $table = 'administrators';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'rol_id','client_id', 'status', 'wallet','history'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    // relations
    public function client()
    {
        return $this->belongsTo('Admins\Client');
    }

    public function role()
    {
        return $this->belongsTo('Admins\Role');
    }

    public function campaigns()
    {
        return $this->hasMany('Admins\Campaign');
    }

    public function subcampaigns()
    {
        return $this->hasMany('Admins\Subcampaign');
    }

    public function wallet()
    {
        return $this->embedsOne('Admins\AdministratorWallet');
    }

    public function movements()
    {
        return $this->hasMany('Admins\AdministratorMovement');
    }

    public function history()
    {
        return $this->embedsMany('Admins\AdministratorHistory');
    }
    // end relations
}
