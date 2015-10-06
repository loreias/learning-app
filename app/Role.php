<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Permission;

class Role extends Model
{


	protected $filable = ['name', 'label']; 

	protected static $baseRoles = [ 'user', 'teacher', 'manager', 'administrator' ];

	protected static $defaultRoleName = 'user';



	static public function getDefaultRoleName ()
	{	
		return self::$defaultRoleName;
	}



	/*
	* --------------------
	* Model RELATION SHIPS 
	* --------------------
	* Users Model
	* Permissions Model
	*/
	
	public function users()
	{	
		return $this->belongsToMany('App\User');			
	}


	

	public function permissions()
	{
		return $this->belongsToMany('App\Permission')->withTimeStamps();
	}


	

	/**
	 * Gives permission to a Role, to execute a specifc task ( can_view, can_edit, can_manage )
	 * Link the role and permission tables in the role_permission table
	 *
	 * @param $Permissions null || string || permission obj 
	 */
	/*
	public function addPermissionTo ( $permission )
	{

		$permissionToAssign = $permission;

		if ( $permission === null ){

			$defaultPermission = Permission::getDefaultPermissionName();
				

			$permissionToAssign = Permission::whereName( $defaultPermission )->get()->first();

		}


		if ( is_string( $permission ) ){

			$permissionToAssign = Permission::whereName( $permission )->get()->first();

		}


		return $this->permissions()->save( $permissionToAssign );
	}
	*/



    /**
     * Get users by role
     *
     * @param $roleName, string
     * @return collection, $users with passed role name 
     */
    public function getUsersByRoleName ( $roleName )
    {
        // get the role id
        $role = $this->whereName( $roleName )->firstOrFail();
    
        // get all users with the defined roleName
        $users = $role->users()->get();

        return $users;
    }

}
