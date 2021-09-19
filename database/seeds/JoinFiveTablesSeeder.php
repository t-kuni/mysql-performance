<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class JoinFiveTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('join_1_records')->truncate();
        DB::table('join_2_records')->truncate();
        DB::table('join_3_records')->truncate();
        DB::table('join_4_records')->truncate();
        DB::table('join_5_records')->truncate();

        $JOIN_1_RECORDS_COUNT = 1000;
        $JOIN_2_RECORDS_COUNT = 1000000;
        $JOIN_3_RECORDS_COUNT = 10000;
        $JOIN_4_RECORDS_COUNT = 1000000;
        $JOIN_5_RECORDS_COUNT = 10000;

        {
            // join_1_records
            $buf = [];
            for ($i = 0; $i < $JOIN_1_RECORDS_COUNT; $i++) {
                $buf[] = [
                    'id' => ($i + 1),
                    'no' => ($i + 1) % 100,
                    'name' => 'join_1_id_' . ($i + 1),
                ];

                if (($i + 1) % 1000 === 0) {
                    DB::table('join_1_records')->insert($buf);
                    $buf = [];
                }
            }
        }
        {
            // join_2_records
            $buf = [];
            for ($i = 0; $i < $JOIN_2_RECORDS_COUNT; $i++) {
                $buf[] = [
                    'id' => ($i + 1),
                    'no' => ($i + 1) % 100,
                    'name' => 'join_2_id_' . ($i + 1),
                    '1_id' => ($i % $JOIN_1_RECORDS_COUNT) + 1,
                    '3_id' => ($i % $JOIN_3_RECORDS_COUNT) + 1,
                ];

                if (($i + 1) % 5000 === 0) {
                    DB::table('join_2_records')->insert($buf);
                    $buf = [];
                }
            }
        }
        {
            // join_3_records
            $buf = [];
            for ($i = 0; $i < $JOIN_3_RECORDS_COUNT; $i++) {
                $buf[] = [
                    'id' => ($i + 1),
                    'no' => ($i + 1) % 100,
                    'name' => 'join_3_id_' . ($i + 1),
                ];

                if (($i + 1) % 5000 === 0) {
                    DB::table('join_3_records')->insert($buf);
                    $buf = [];
                }
            }
        }
        {
            // join_4_records
            $buf = [];
            for ($i = 0; $i < $JOIN_4_RECORDS_COUNT; $i++) {
                $buf[] = [
                    'id' => ($i + 1),
                    'no' => ($i + 1) % 100,
                    'name' => 'join_4_id_' . ($i + 1),
                    '3_id' => ($i % $JOIN_3_RECORDS_COUNT) + 1,
                    '5_id' => ($i % $JOIN_5_RECORDS_COUNT) + 1,
                ];

                if (($i + 1) % 5000 === 0) {
                    DB::table('join_4_records')->insert($buf);
                    $buf = [];
                }
            }
        }
        {
            // join_5_records
            $buf = [];
            for ($i = 0; $i < $JOIN_5_RECORDS_COUNT; $i++) {
                $buf[] = [
                    'id' => ($i + 1),
                    'no' => ($i + 1) % 100,
                    'name' => 'join_5_id_' . ($i + 1),
                ];

                if (($i + 1) % 5000 === 0) {
                    DB::table('join_5_records')->insert($buf);
                    $buf = [];
                }
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}
