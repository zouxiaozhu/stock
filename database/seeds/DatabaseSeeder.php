<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(AdminAuthRoleSeeder::class);
        $this->call(TerminalSettingSeeder::class);
        $this->call(ChartsSeeder::class);
    }
}
