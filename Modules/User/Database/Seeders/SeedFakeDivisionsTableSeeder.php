<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Entities\Division;
use Illuminate\Database\Eloquent\Model;

class SeedFakeDivisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");

        Division::create([
            'd_name' => 'Division 1',
        ]);

        Division::create([
            'd_name' => 'Division 2',
        ]);

        Division::create([
            'd_name' => 'Division 2',
        ]);
    }
}
