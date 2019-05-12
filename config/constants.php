<?php
/**
 * Created for TechFlake
 * Created by Gaurang Joshi <gaurangnil@gmail.com>
 * User: Gaurang Joshi
 * Date: 13/04/2019
 * Time: 02:43 PM
 */

return [
    'response_code' => [
        'success' => 0,
        'error' => 1,
        'data_not_found' => 2,
        'exception_exit' => 8
    ],
    'default' => [
        'db_offset' => 0,
        'db_limit' => 10,
        'max_execution_time' => 30,
        'frontend_time_format' => 'H:i',
        'frontend_date_format' => 'd-m-Y',
        'frontend_datetime_format' => 'd-m-Y H:i',
        'system_datetime_format' => 'Y/m/d H:i:s'
    ],
    'user' => [
        'max_execution_time_for_data_patch' => 3600, /* It's 1.0 hr because, here 50000 records needs time to insert */
        'total_insert_data_count' => 50000,
        'batch_insert_data_count' => 1000
    ]
];
