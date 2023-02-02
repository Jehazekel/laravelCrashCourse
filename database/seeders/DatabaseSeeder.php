<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Listing;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()  //used to generate dummy users : execute using ' '
    {

        // Creating a single user with multiple listings
        $user = User::factory()->create([
            'name'=> 'Bob',
            'email'=> 'bob@gmail.com'
        ]);

        Listing::factory(6)->create([
            'user_id' => $user->id
        ]);

        // \App\Models\User::factory(2)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Using Custom factory to generate random Listings 
        // 1. Generate Model : 'php artisan migrate:model [Name]'
        // 2. Generate Factory : 'php artisan make:factory [NameFactory]'
        // 3. Call Factory : 'Listing::factory(6)->create()' 
        // 4. Execute DB Seed : 'php artisan db:seed' OR 'php artisan migrate:refresh --seed' 

            // Listing::factory(6)->create();

        // Creating random generated Listing
        // Listing::create([
        //     'id' => 1,
        //     'title' => 'Listing One',
        //     'description' => 'random' ,
        //     'company' => 'Acme Corp' ,
        //     'location' => 'Boston, MA' ,
        //     'email' => 'email@random',
        //     'tags' => 'python', 
        //     'website' => 'www.google.com' ,
        // ]);


        // Listing::create([
        //     'id' => 2,
        //     'title' => 'Listing Two',
        //     'description' => 'Guy Sensei' ,
        //     'company' => 'Tec Corp' ,
        //     'location' => 'Florida, MA' ,
        //     'email' => 'email@user',
        //     'tags' => 'laravel, javascript', 
        //     'website' => 'www.yahoo.com' ,
        // ]);



    }
}
