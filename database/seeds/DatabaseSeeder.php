<?php

//namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\Database\Seeders\GroupByRecordTableSeeder::class);
        $this->call(\Database\Seeders\SingleIndexRecordTableSeeder::class);
        $this->call(\Database\Seeders\MultiIndexRecordTableSeeder::class);
        $this->call(\Database\Seeders\JoinFiveTablesSeeder::class);

//        DB::table('users')->truncate();
//        DB::table('user_details')->truncate();
//
//        // 試しに一回流す
//        $data = $this->makeData(0, 'userFactory', 1);
//        DB::table('users')->insert($data);
//        $data = $this->makeData(0, 'userDetailFactory', 1);
//        DB::table('user_details')->insert($data);
//
//        // $this->call(UsersTableSeeder::class);
//        DB::table('users')->truncate();
//        DB::table('user_details')->truncate();
//
//        for ($i = 0; $i < 40; $i++) {
//            $data = $this->makeData($i, 'userFactory', 2500);
//            DB::table('users')->insert($data);
//        }
//
//        for ($i = 0; $i < 40; $i++) {
//            $data = $this->makeData($i, 'userDetailFactory', 2500);
//            DB::table('user_details')->insert($data);
//        }
    }

    private function makeDataThousand($baseIndex, $factory)
    {
        return $this->makeData($baseIndex, $factory, 1000);
    }

    private function makeData($baseIndex, $factory, $count = 1000)
    {
        $rows = [];
        for ($i = 0; $i < $count; $i++) {
            $rows[] = $this->$factory(($baseIndex * $count) + $i);
        }
        return $rows;
    }

    private function userFactory($i)
    {
        return [
            'name'                => $this->faker->name,
            'type_kind_2'         => $i % 2,
            'type_kind_2_index'   => $i % 2,
            'type_kind_3'         => $i % 3,
            'type_kind_3_index'   => $i % 3,
            'type_kind_4'         => $i % 4,
            'type_kind_4_index'   => $i % 4,
            'type_kind_10'        => $i % 10,
            'type_kind_10_index'  => $i % 10,
            'seq'                 => $i,
            'seq_index'           => $i,
            'rand'                => rand(1, 10000),
            'rand_index'          => rand(1, 10000),
            'rand_nullable'       => $i % 3 === 0 ? null : rand(1, 10000),
            'rand_nullable_index' => $i % 3 === 0 ? null : rand(1, 10000),
            'boolean_10'          => $i % 10 === 0,
            'boolean_9'           => $i % 9 === 0,
        ];
    }

    private function userDetailFactory($i)
    {

        return [
            'user_id'             => $i / 5, // ユーザ毎に5レコードづつ
            'type_kind_2'         => $i % 2,
            'type_kind_2_index'   => $i % 2,
            'type_kind_3'         => $i % 3,
            'type_kind_3_index'   => $i % 3,
            'type_kind_4'         => $i % 4,
            'type_kind_4_index'   => $i % 4,
            'type_kind_10'        => $i % 10,
            'type_kind_10_index'  => $i % 10,
            'seq'                 => $i,
            'seq_index'           => $i,
            'nullable_a'          => ($i % 2 === 0) ? $i : null,
            'nullable_b'          => ($i % 3 === 0) ? $i : null,
            'nullable_c'          => ($i % 4 === 0) ? $i : null,
            'nullable_a_index'    => ($i % 2 === 0) ? $i : null,
            'nullable_b_index'    => ($i % 3 === 0) ? $i : null,
            'nullable_c_index'    => ($i % 4 === 0) ? $i : null,
            'rand'                => rand(1, 10000),
            'rand_index'          => rand(1, 10000),
            'rand_nullable'       => $i % 3 === 0 ? null : rand(1, 10000),
            'rand_nullable_index' => $i % 3 === 0 ? null : rand(1, 10000),
        ];
    }
}
