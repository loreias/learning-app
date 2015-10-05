<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


use App\Role;


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

   

    /**
     * form rules for creating a user
     */
    public static $rules = [
        'first_name'            => 'required',
        'last_name'             => 'required',
        'email'                 => 'required|email|unique:users',
        'password'              => 'required|min:6|max:20',
        'password_confirmation' => 'required|same:password',
        'role'                  => 'sometimes|required',
    ];



    /**
     * For Flash messaging sys
     */
    public static $messages = [
        'first_name.required'   => 'First Name is required',
        'last_name.required'    => 'Last Name is required',
        'email.required'        => 'Email is required',
        'email.email'           => 'Email is invalid',
        'password.required'     => 'Password is required',
        'password.min'          => 'Password needs to have at least 6 characters',
        'password.max'          => 'Password maximum length is 20 characters',
    ];    





    /*
    |----------------------------
    | USER Relation ships
    |----------------------------
    */

    
    /**
     * RELATIONSHIPS
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
        return $this->belongsToMany('App\Role');        
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
     * @param $name : string, name of the role to check || object
     * @return bool
     */
    public function hasRole($name)
    {
        
        if( is_string($name) ){
            return $this->roles->contains('name', $name);
            /*
            return in_array($name, array_fetch($this->roles->toArray(), 'name'));
            foreach ($this->roles as  $role)
            {
                if ( $role->name == $name ) return true;
            } 
            */
        }
 

        /**
         * is the passed argument is a object
         * same result
         * return !! $name->interserc( $this->roles)->count()
         */
        foreach ($name as $role ) {

            if ($this->hasRole( $role->name )){
                return true;
            }
        }
 
        return false;
    }
 



    /**
     * Attach a particular role to the user by adding it to the pivot table role_user
     *
     * @param $role : null || string || role object
     */
    public function assignRole ( $role )
    {

        $roleToAssign = $role;
        
        # assign default role of user
        # role needs to already exist in db
        if( $role === null ) {

            $defaultRole = Role::getDefaultRoleName();
            $roleToAssign = Role::whereName( $defaultRole )->firstOrFail();
            // $roleToAssign = Role::whereName( $defaultRole )->get()->first();

        }


        # if pass role is a string
        # fetch the role
        if( is_string( $role )){
            
            $roleToAssign = Role::whereName( $role )->firstOrFail();
            // $roleToAssign = Role::whereName( $role )->get()->first();
        }

        # save the given role
        return $this->roles()->save( $roleToAssign );     
        
    }





    /**
     * Remove a role from a user
     *
     * @param $role object
     */
    public function removeRole ( $role )
    {
        return $this->roles()->detach($role);
    }


}