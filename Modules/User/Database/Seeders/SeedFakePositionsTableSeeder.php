<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Entities\Position;
use Illuminate\Database\Eloquent\Model;

class SeedFakePositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Model::unguard();

        // $this->call("OthersTableSeeder");

        Position::create([
            'p_name' => 'Position 1',
        ]);

        Position::create([
            'p_name' => 'Position 2',
        ]);

        Position::create([
            'p_name' => 'Position 2',
        ]);
    }
}
