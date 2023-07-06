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
                'company_id'=>'1',
                'stream_name' => 'Web_Front_End'

              ],
            [
                'id' => 2,
                'project_id' => '5',
                'user_id' => '11',
                'company_id'=>'1',
                'stream_name' => 'Back_End'
              ],
             [
                'id' => 3,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'Desktop_Front_End'
             ],
              [
                'id' => 4,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'Idle Time'
              ],
              [
                'id' => 5,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'7',
                'stream_name' => 'Service'
              ],
              [
                'id' => 6,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'7',
                'stream_name' => 'Sale'
              ],
              [
                'id' => 7,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'7',
                'stream_name' => 'MentorShip'
              ],
              [
                'id' => 8,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'7',
                'stream_name' => 'Learning'
              ]
           ];
     
        DB::table('streams')->insert($stream);
    }
}
