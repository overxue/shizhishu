<?php

use Illuminate\Database\Seeder;
use App\Models\Address;

class AddressesTableSeeder extends Seeder
{
    public function run()
    {
        factory(Address::class, 10)->create();
    }
}
