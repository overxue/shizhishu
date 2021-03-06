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
        $this->call(BannersTableSeeder::class);
        $this->call(AddressesTableSeeder::class);
        $this->call(CouponsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(ProductImagesTableSeeder::class);
    }
}
