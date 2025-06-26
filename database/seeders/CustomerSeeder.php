<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            ['name' => 'Arjun R', 'email' => 'arjun@example.com', 'phone' => '9876543210'],
            ['name' => 'Divya M', 'email' => 'divya@example.com', 'phone' => '9876543211'],
            ['name' => 'Rahul K', 'email' => 'rahul@example.com', 'phone' => '9876543212'],
            ['name' => 'Sneha P', 'email' => 'sneha@example.com', 'phone' => '9876543213'],
            ['name' => 'Kiran V', 'email' => 'kiran@example.com', 'phone' => '9876543214'],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
