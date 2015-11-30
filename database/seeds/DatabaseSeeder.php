<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use App\Maker;
use App\User;
use App\Type;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Truncated (delete) the data, but ignore primary and foreign key definitions
    	// (otherwise we cannot delete records in the Makers table while vehicles still have a reference to it)
    	DB::statement('SET FOREIGN_KEY_CHECKS = 0');
    	Maker::truncate();
        User::truncate();
        Type::truncate();
        DB::table('oauth_clients')->truncate();

        Model::unguard();

        $this->call('MakerSeed');
        $this->call('TypesSeed');
        $this->call('VehiclesSeed');
        $this->call('UsersSeed');
        $this->call('OauthClientSeed');

        Model::reguard();
    }
}
