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
                'company_id'=>'1',
                'stream_name' => 'Mentorship'
              ],
              [
                'id' => 8,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'Learning'
              ],
              [
                'id' => 9,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'Administration'
              ],
              [
                'id' => 10,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'BASIS'
              ],
              [
                'id' => 11,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'FI'
              ],
              [
                'id' => 12,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'FICO Stream'
              ],
              [
                'id' => 13,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'HCM/SF'
              ],
              [
                'id' => 14,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'MM'
              ],
              [
                'id' => 15,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'PMO'
              ],
              [
                'id' => 16,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'PP/QM'
              ],
              [
                'id' => 17,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'SD/LE'
              ],
              [
                'id' => 18,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'FICO Support'
              ],
              [
                'id' => 19,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'Support'
              ],
              [
                'id' => 20,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'Ariba'
              ],
              [
                'id' => 21,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'HCM'
              ],
              [
                'id' => 22,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'SD'
              ],
              [
                'id' => 23,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'SF'
              ],
              [
                'id' => 24,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'FMH'
              ],
              [
                'id' => 25,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'DMS'
              ],
              [
                'id' => 26,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'Marketing'
              ],
              [
                'id' => 27,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'MDSap'
              ],
              [
                'id' => 28,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'SOLMAN'
              ],
              [
                'id' => 29,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'BI'
              ],
              [
                'id' => 30,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'FM/GM'
              ],
              [
                'id' => 31,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'PS'
              ],
              [
                'id' => 32,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'SLcM Admin'
              ],
              [
                'id' => 33,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'SLcM FI'
              ],
              [
                'id' => 34,
                'project_id' => '5',
                'user_id' => '12',
                'company_id'=>'1',
                'stream_name' => 'Consultancy'
              ]
           ];
     
        DB::table('streams')->insert($stream);
    }
}
