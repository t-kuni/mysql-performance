<?php

use Faker\Generator as Faker;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * @var Faker
     */
    private $faker;

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $this->faker = $faker;

        // $this->call(UsersTableSeeder::class);
        DB::table('users')->truncate();
        DB::table('user_details')->truncate();

        for ($i = 0; $i < 100; $i++) {
            $data = $this->makeDataThousand($i, 'userFactory');
            DB::table('users')->insert($data);
        }

        for ($i = 0; $i < 100; $i++) {
            $data = $this->makeDataThousand($i, 'userDetailFactory');
            DB::table('user_details')->insert($data);
        }
    }

    private function makeDataThousand($baseIndex, $factory)
    {
        $rows = [];
        for ($i = 0; $i < 1000; $i++) {
            $rows[] = $this->$factory(($baseIndex * 1000) + $i);
        }
        return $rows;
    }

    private function userFactory($i)
    {
        return [
            'name'               => $this->faker->name,
            'type_kind_2'        => $i % 2,
            'type_kind_10'       => $i % 10,
            'seq'                => $i,
            'type_kind_2_index'  => $i % 2,
            'type_kind_10_index' => $i % 10,
            'seq_index'          => $i,
            'rand'               => rand(1, 10000),
            'rand_index'         => rand(1, 10000),
        ];
    }

    private function userDetailFactory($i)
    {

        return [
            'user_id'            => $i / 5, // ユーザ毎に5レコードづつ
            'type_kind_2'        => $i % 2,
            'type_kind_10'       => $i % 10,
            'seq'                => $i,
            'type_kind_2_index'  => $i % 2,
            'type_kind_10_index' => $i % 10,
            'seq_index'          => $i,
            'nullable_a'         => ($i % 2 === 0) ? $i : null,
            'nullable_b'         => ($i % 3 === 0) ? $i : null,
            'nullable_c'         => ($i % 4 === 0) ? $i : null,
            'nullable_a_index'   => ($i % 2 === 0) ? $i : null,
            'nullable_b_index'   => ($i % 3 === 0) ? $i : null,
            'nullable_c_index'   => ($i % 4 === 0) ? $i : null,
            'rand'               => rand(1, 10000),
            'rand_index'         => rand(1, 10000),
        ];
    }
}
