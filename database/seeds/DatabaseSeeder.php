<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /*
    // protected $faker;
    // protected $role;

    public function __construct ( Faker\Generator $faker, App\Role $role )
    {
        // $this->faker = $faker;
        // $this->role = $role;
    }
    */


    protected $truncateTables = ['users', 'levels', 'roles', 'permissions'];

    /**
     * Run the database seeds.
     *
     * @return void
     * php artisan db:seed
     */
    public function run( )
    {
        Model::unguard();

        /*
        foreach ($this->truncateTables as $table) {
            DB::table($table)->truncate();
        }
        */

        // composer dump-autoload, to get seed external class to be found

        $rolesArray     = array(
            'user'              => 'usuario', 
            'teacher'          => 'Profesor',
            'manager'          => 'Moderador',
            'administrator'     => 'Super Admin'
        );

 

        $permisArray    = array(
            'can_view'      => 'View Content', 
            'can_edit'      => 'Teachers', 
            'can_manage'    => 'Site Manager', 
            'can_admin'     => 'Site Administrator'
        );


        foreach ($rolesArray as $name => $label) {
            factory(App\Role::class)->create([
                'name'  => $name,
                'label' => $label,
            ]);
        }


        // factory(App\Permission::class, 4)->create();
        foreach ($permisArray as $name => $label) {
            factory(App\Permission::class)->create([
                'name'  => $name,
                'label' => $label,
            ]);
        }





        // $randomIndex = $this->faker->numberBetween(1,4);

        factory(App\User::class, 10)->create()->each( function( $u ) {
            
            // create levels and relatinship    
            $u->levels()->save(factory(App\Level::class)
                ->create([
                    'user_id'           => $u->id,
                    'updated_by_id'     => $u->id,                
                ])
            );
            
            // create roles and user relationshipt    
            $u->roles()->save( App\Role::find(rand(1,4)) );    
        });


        factory(App\Lesson::class, 10)->create();

        Model::reguard();
    }


}
