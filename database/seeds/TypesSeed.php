<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Type;

use Faker\Factory as Faker;


class TypesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // make sure the table is empty
        DB::table('types')->delete();

        // create a new faker object
        $faker = Faker::create();

        for($i=0; $i<10; $i++) 
        {
            Type::create
            ([
                'name'    => $faker->word(),
            ]);
        }
    }
}
