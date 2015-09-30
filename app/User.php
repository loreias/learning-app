<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
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
    protected $fillable = ['first_name', 'last_name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['remember_token', 'password'];


    public static $rules = [
        'first_name'            => 'required',
        'last_name'             => 'required',
        'email'                 => 'required|email|unique:users',
        'password'              => 'required|min:6|max:20',
        'password_confirmation' => 'required|same:password',
        'role'                  => 'sometimes|required',
    ];



    
    public static $messages = [
        'first_name.required'   => 'First Name is required',
        'last_name.required'    => 'Last Name is required',
        'email.required'        => 'Email is required',
        'email.email'           => 'Email is invalid',
        'password.required'     => 'Password is required',
        'password.min'          => 'Password needs to have at least 6 characters',
        'password.max'          => 'Password maximum length is 20 characters',
    ];    




    /**
     * RELATIONSHIPS
     * A USER CAN HAVE MANY ARTICLES
     * this will be use to associate the current user with any level created by the current user 
     * this map the relationship at laravel level, still needs to map the same connection for the database structure in the migration class for this table users    
     */
    public function levels()
    {

        /**
         * this creates a relationship one to many, one user can have many articles using the Levels module
         * so to retrive the levels created by this user user->levels();
         */
        return $this->hasMany('App\Level');
    }




    /**
     * Relation ship Lesson
     * hasMany
     */
    public function lessons()
    {
        return $this->hasMany('App\Lesson');
    }


    /**
     * Rlationship with Role Class
     * belongsToMany
     * http://alexsears.com/article/adding-roles-to-laravel-users
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role')->withTimestamps();        
    }


    /**
     * Relationshipt with SocialProfile Class
     * Many to one
     */
    public function socialProfiles ()
    {
        return $this->belongsToMany('App\socialProfiles')->withTimestamps();
    }



    /**
     * Find out if user has a specific role
     *
     * @param $name : string, name of the role to check
     * @return bool
     */
    public function hasRole($name)
    {
        //return in_array($name, array_fetch($this->roles->toArray(), 'name'));
 
        foreach ($this->roles as  $role)
        {
            if ( $role->name == $name ) return true;
        } 
 
        return false;
    }
 



    /**
     * Attach a particular role to the user
     *
     * @param $role : object, role to be attach
     * @return 
     */
    public function assignRole ( $role )
    {
        return $this->roles()->attach($role);     
    }


    /**
     * Remove a role from a user
     *
     * @param $role
     */
    public function removeRole ( $role)
    {
        return $this->roles()->detach($role);
    }
   
}