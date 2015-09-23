<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Maker;

use Faker\Factory as Faker;

class MakerSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        //echo $faker->word();die();
        //var_dump($faker);die();

        for($i=0; $i<100; $i++) 
        {
            Maker::create
            ([
                'name'  => $faker->company(),
                'phone' => $faker->phoneNumber()
            ]);
        }
    }
}
