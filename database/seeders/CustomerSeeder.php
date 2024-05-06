<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        // Create sample customers
        Customer::create([
            'first_name' => 'Customer',
            'last_name' => 'xxx',
            'email' => 'john@example.com',
            'phone' => '1234567890',
            'address' => '123 Main St',
            'avatar' => 'customer/blank.jpg',
            'user_id' => 1, 
            'birth_day' => 15,
            'birth_month' => 1,
            'client_id' => 'ISPPOS',
        ]);

        // Add more customers as needed
    }
}

