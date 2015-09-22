<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Vehicle;

use Faker\Factory as Faker;

class VehiclesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i=0; $i<30; $i++) 
        {
            Vehicle::create
            ([
                'color'    => $faker->safeColorName(),
                'power'    => $faker->numberBetween(25,500),
                'capacity' => $faker->numberBetween(250,6000),
                'speed'    => $faker->randomFloat(1,25,200),
                'maker_id' => $faker->numberBetween(1,5)
            ]);
        }
    }
}
