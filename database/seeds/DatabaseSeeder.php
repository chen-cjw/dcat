<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     * 指定填充 php artisan db:seed --class=UserAddressTableSeeder
     * @return void
     */
    public function run()
    {
         $this->call(UserTableSeeder::class);
         $this->call(UserAddressTableSeeder::class);
         $this->call(AdminTablesSeeder::class);
    }
}
