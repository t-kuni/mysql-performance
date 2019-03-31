<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

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
        ];
    }
}
