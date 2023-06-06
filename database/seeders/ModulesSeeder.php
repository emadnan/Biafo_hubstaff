<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Seeder;

class ModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Array of module data
        $modules = [
            [
                'name' => 'Ariba',
                'description' => 'Description for Module 1',
            ],
            [
                'name' => 'BASIS',
                'description' => 'Description for Module 2',
            ],
            [
                'name' => 'CO',
                'description' => 'Description for Module 3',
            ],
            [
                'name' => 'DMS',
                'description' => 'Description for Module 4',
            ],
            [
                'name' => 'EWM',
                'description' => 'Description for Module 5',
            ],
            [
                'name' => 'FI',
                'description' => 'Description for Module 6',
            ],
            [
                'name' => 'FM',
                'description' => 'Description for Module 7',
            ],
            [
                'name' => 'GM',
                'description' => 'Description for Module 8',
            ],
            [
                'name' => 'HCM',
                'description' => 'Description for Module 9',
            ],
            [
                'name' => 'MM',
                'description' => 'Description for Module 10',
            ],
            [
                'name' => 'PM',
                'description' => 'Description for Module 11',
            ],
            [
                'name' => 'PP',
                'description' => 'Description for Module 12',
            ],
            [
                'name' => 'QM',
                'description' => 'Description for Module 13',
            ],
            [
                'name' => 'SAC',
                'description' => 'Description for Module 14',
            ],
            [
                'name' => 'SD',
                'description' => 'Description for Module 15',
            ],
            [
                'name' => 'SF',
                'description' => 'Description for Module 16',
            ],
            [
                'name' => 'SLcM-FICA',
                'description' => 'Description for Module 17',
            ],
            [
                'name' => 'SLcM-Admin',
                'description' => 'Description for Module 18',
            ],
            [
                'name' => 'TM',
                'description' => 'Description for Module 19',
            ],

            // Add more modules as needed
        ];

        // Insert module data into the database
        DB::table('modules')->insert($modules);

    }
}
