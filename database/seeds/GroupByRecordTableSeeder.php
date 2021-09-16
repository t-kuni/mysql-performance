<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class GroupByRecordTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('group_by_records')->delete();

        $buf = [];
        for ($i = 0; $i < 100000; $i++) {
            $buf[] = [
                'text' => 'text' . ($i % 100),
                'no' => $i % 100
            ];

            if ($i % 5000 === 0) {
                DB::table('group_by_records')->insert($buf);
                $buf = [];
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}
