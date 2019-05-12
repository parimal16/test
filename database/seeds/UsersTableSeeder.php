<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        ini_set('max_execution_time', Config::get('constants.user.max_execution_time_for_data_patch'));
        $start_time = microtime(true);
        $insert_data = Config::get('constants.user.total_insert_data_count');
        $batch_size = Config::get('constants.user.batch_insert_data_count');
        for($i=0;$i<($insert_data/$batch_size);$i++) {
            $users_data = array();
            for($j=0;$j<$batch_size;$j++) {
                if(0 == (\App\Users::whereEmail('tutor'.$i.$j.'@techflake.local')->count())) {
                    $user_data = array(
                        'name' => 'Tutor '.$i.$j,
                        'email' => 'tutor'.$i.$j.'@techflake.local',
                        'password' => Hash::make('admin123'),
                        'email_verified_at' => date(Config::get('constants.default.system_datetime_format')),
                        'created_at' => date(Config::get('constants.default.system_datetime_format')),
                        'updated_at' => date(Config::get('constants.default.system_datetime_format')),
                    );
                    array_push($users_data, $user_data);
                }
            }
            if (!empty($users_data)) {
                \App\Users::insert($users_data);
            }
            $data_inserted_count = \App\Users::count();
            Log::debug('Total Data Inserted: '. $data_inserted_count);
        }
        $end_time = microtime(true);
        ini_set('max_execution_time', Config::get('constants.default.max_execution_time'));
        Log::info('Script Execution Time: ' . gmdate("i:s", ($end_time-$start_time)));
    }
}
