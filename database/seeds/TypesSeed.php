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
        $faker = Faker::create();

        for($i=0; $i<10; $i++) 
        {
            Type::create
            ([
                'name'    => $faker->name(),
            ]);
        }
    }
}
