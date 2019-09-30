<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class tevent extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;
    
    //default är att det måste finns timestampkolumner i varje databastabell
    public $timestamps = false;

    //Ändra primary key name (default är alltid "id")
    protected $primaryKey = 'Event_ID';

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
         'Event_Object', 
         'Event_Title', 
         'Event_Course_Code', 
         'Event_Org', 
         'Start_Date',
         'End_Date',
         'Event_Time',
         'Start_Time',
         'End_Time',
         'Cust_Epost',
         'Event_Number_Of_Persons',
         'Event_Customer',
         'Event_Tech_Support',
         'Event_Furniture_Support',
         'Event_Extra_Equipment',
         'Event_Details',
         'Date_Added',
         'Event_Booker',
         'Event_Kundnr',
         'RT_thread',
         'Fakturerad',
         'Event_Status'
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
