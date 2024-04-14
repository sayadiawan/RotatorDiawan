<?php

namespace Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\User\Entities\Role;
use Illuminate\Database\Eloquent\Model;

class SeedFakeRolesTableSeeder extends Seeder
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

        Role::create([
            'r_name' => 'Admin',
        ]);

        Role::create([
            'r_name' => 'Owner',
        ]);

        Role::create([
            'r_name' => 'Member',
        ]);
    }
}
