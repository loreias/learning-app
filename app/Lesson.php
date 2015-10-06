<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{

	protected $table = 'lessons';


	/**
	 * --------------------
	 * MODEL RELATION SHIPS
	 * --------------------
	 * User
	 * Level
	 */
	public function user ()
	{
		return $this->belongsTo('App\User');
	}



	public function level ()
	{
		return $this->belongsTo('App\Level');
	}

}