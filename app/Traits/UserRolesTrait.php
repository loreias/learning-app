<?php 

namespace App\Traits;


trait UserRolesTrait {

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
     * Find out if user has a specific role
     *
     * @param $name : string, name of the role to check || object
     * @return bool
     */
    public function hasRole( $name )
    {
        
        if( is_string( $name ) ){
            
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