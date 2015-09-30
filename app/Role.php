<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    

	protected $filable = ['name']; 


	/**
	 * Relationsheep with User Class
	 * hasMany 
	 */
	public function users()
	{	
		return $this->belongsToMany('App\User');			
	}

	/**
	 * validate if given role exist in db
	 * @param $roleName, string, role to look up in db
	 * @return bool 
	 */
	public function existInDb ( $roleName )
	{

		if( empty($this->where('name', '=', $roleName)->first()) ){

			return false;	
		}
		
		return true;
	}

	/**
	 * Create role
	 * @param roleNam, string
	 * @return Obj roleName
	 */
	public function createNew ($roleName)
	{
		$this->name = $roleName;
		return $this->save();
	}

}
