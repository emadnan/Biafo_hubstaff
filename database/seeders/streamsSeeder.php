<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class streamsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $stream =  [
            [
                'id' => 1,
                'project_id' => '5',
                'user_id' => '10',
                'stream_name' => 'Web_Front_End'

              ],
            [
                'id' => 2,
                'project_id' => '5',
                'user_id' => '11',
                'stream_name' => 'Back_End'
              ],
             [
                'id' => 3,
                'project_id' => '5',
                'user_id' => '12',
                'stream_name' => 'Desktop_Front_End'
              ]
           ];
     
        DB::table('streams')->insert($stream);
    }
}
