<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MultiIndexRecordTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        DB::table('multi_index_records')->delete();

        $buf = [];
        for ($i = 0; $i < 100000; $i++) {
            $buf[] = [
                'text' => 'text' . ($i % 100),
                'no' => $i % 100
            ];

            if ($i % 5000 === 0) {
                DB::table('multi_index_records')->insert($buf);
                $buf = [];
            }
        }

        Schema::enableForeignKeyConstraints();
    }
}
