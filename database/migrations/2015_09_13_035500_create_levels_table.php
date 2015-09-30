<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('levels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();// forner key for user id and needs to be positive(unsigned)
            $table->integer('level_index');
            $table->string('title');
            $table->string('description');
            $table->integer('state'); // referes to the active state of the current level (draft/publish/un-publish/deleted)
            // $table->integer('created_by')->unsigned(); // refrences to the user id that created this level
            $table->integer('updated_by'); //id of last user to edit this level
            $table->text('tags');
            $table->timestamp('published_at');
            $table->timestamp('deleted_at');
            $table->timestamps();

            // maps relation between forner key and source table    
            $table->foreign('user_id')      // forner key on this table
                    ->references('id')      // refrence on the source table
                    ->on('users')           // table been refrences 
                    ->onDelete('no action'); //this will be in case user deletes the account will cascate down and delete any assiated or map date of it
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('levels');
    }
}
