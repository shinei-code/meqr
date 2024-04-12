<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 外部キー制約が有る場合のチェックを無視
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        \DB::table('users')->truncate();

        \App\Models\User::factory()->create([
            'staff_no' => 1,
            'name' => 'システム管理者',
        ]);
        \App\Models\User::factory(5)->create();

        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }
}
