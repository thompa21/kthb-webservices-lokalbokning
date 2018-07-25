<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class tobject extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;
    
    //default är att det måste finns timestampkolumner i varje databastabell
    public $timestamps = false;

    //Ändra primary key name (default är alltid "id")
    protected $primaryKey = 'Object';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    //default är att tabellnamnet = modelnamnet + 's' (tevents)
    //protected $table = 'tevents';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'Category', 'Grp', 'Pricegroup'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    /*
    protected $hidden = [
        'password_hash'
    ];
    */
}
