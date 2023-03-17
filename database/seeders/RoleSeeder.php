<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role =  [
          [
              'id' => 1,
              'name' => 'Admin',
              'guard_name' => 'API'
            ],
          [
              'id' => 2,
              'name' => 'Super Admin',
              'guard_name' => 'API'
            ],
           [
              'id' => 3,
              'name' => 'Company Admin',
              'guard_name' => 'API'
            ],
           [
              'id' => 4,
              'name' => 'user',
              'guard_name' => 'API'
            ],
           [
              'id' => 5,
              'name' => 'HR',
              'guard_name' => 'API'
            ]
           
           
         ];
   
      DB::table('roles')->insert($role);
    }
}
