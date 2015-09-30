<?php

namespace App\Http\Controllers;

#import controller Level class
use App\Level;
use App\User;

use App\Http\Requests;

use App\Http\Requests\LevelRequest;

use Illuminate\Http\Request;

use Illuminate\HttpResponse; 

use App\Http\Controllers\Controller;

use Carbon\Carbon;



# use in store method
# use Request;
#use App\Http\Requests\CreateLevelRequest;


# validation for level create
//use Requests;

class LevelsController extends Controller
{
   
	/**
	* Display all levels
	* load the Levels view
	* name space imported at the top use App\Level
	*/
    public function index()
    {
    	//return 'Display levels veiew';
    	# refrence the complete namespace for the Level Class
    	// $levels = \App\Level::all();

    	# get all data from the levels table
    	//$levels = Level::all(); 

        # get all data from levels table in DESC order
        # another way will be Level::orderBy('published_at', 'desc')->get();
        // $levels = Level::latest('published_at')->get();
        // $levels = Level::orderBy('level_index', 'ASC')->get();

        #Do not display Levels set for future date publishment 
        # $levels = Level::orderBy('level_index', 'ASC')
        #            ->where('published_at', '<=', Carbon::now()) // display only levels that pusblist_at time es equoal or grather than now. 
        #                ->get();

        /**
         * using scope to get the same resutl as above
         * this part "->where('published_at', '<=', Carbon::now())" it's been abstacted to Level model in a published method  
         * this will help in situation where need to replacate this same logic and keep clean the controller
         */
        $levels = level::orderBy('level_index', 'ASC')->published()->get();



    	/**
    	* return a view inside levels call index.blade.php
    	*	pass to that view the array levels with the compact format
    	*	an other way view('view_name')->with('levels', $levels);
    	*/
    	return view('levels.index', compact('levels'));
    }




    /**
    * Display single level
    *
    */
    public function show($id)
    {

    	# using elocuent get from the levels table the id pass through the route 	
    	# $level = Level::find($id);
    	
    	# find: get the id from levels table
    	# OrFail: veryfy if the id exist in the table if not fails and througs expetion 404
    	$level = Level::findOrFail($id);


    	/**
    	* change to be accept a slug and id, when id create validation for  load the level and is_number like drupal
    	* 
    	*/
    	return view('levels.show', compact('level'));
    }



    /**
     * response to a create level route
     * get: levels/create
     */
    public function create()
    {

        # will be use as current level_index for sorting the levels
        $currentLevelIndex = Level::lastLelveIndex();    

    	return view('levels.create', compact('currentLevelIndex'));
    }


    /**
     * save new level into db
     * @param CreateLevelRquest
     * @return response
     *
     * when type hinting a request, this will be process before the body of the method store runs
     * validation fails, redirect back to the las route
     * validation success, process the store method   
     */
    public function store(LevelRequest $request)
    { 
        /**
         * NOTE
         * Laravel FORM REQUEST could be use directly in the controller vor validating simple forms not throug the request class
         *
         */


        # gets super globals $_POSTS and $_GETS
        // $input = Request::all('title'); // get just the input with name attr =  title
        
        # fetch the inputs
        // $input = Request::all();

        # get the request object from the validation method defined
        $input = $request->all();

        /**
         * adding data to db with eloquent
         */  
        #adding inputs one by one
        #$level  = new Level;
        #$level->title = $input['title']

        /*
        $level = new Level([
            'user_id'       =>  $input['user_id'],
            'title'         =>  $input['title'],
            'description'   =>  $input['description'],
            'published_at'  =>  $input['published_at'],
            'level_index'   =>  $input['level_index'],
        ]);


        if( $level->save() ){
            # redirect to levels page
            return redirect('levels');
        }
        */    




        /**
         * adding to db with mass asignment
         * Reference to the Level Class wich is name space at the top
         * Class need to specify which field in the database are allow for mass assingment
         */
        Level::create($input);
        return redirect('levels');


    }


    /**
     * Display view for edit level
     *
     * @return view 
     */
    public function edit($id)
    {

        # get the pass levels
        $level = Level::findOrFail($id);

        return view('levels.edit', compact('level'));
    }



    /**
     * response to update Level patch request
     *  
     * @param $id, strin, level id 
     * @param $request, obj, object that have refrence of the post,patch,get,etc super globals by method injection
     *
     * @return redirect to page
     */
    public function update($id, LevelRequest $request)
    {

        $level = Level::findOrFail($id);

        $updateLevel = $request->all();

        //$level->udpate($request->all());
        
        $level->title           = $updateLevel['title'];
        $level->description     = $updateLevel['description'];
        $level->published_at    = $updateLevel['published_at'];
        $level->level_index     = $updateLevel['level_index'];

        $level->save();

        return redirect('levels');

    }

}