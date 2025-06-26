<?php

namespace Database\Seeders;

use App\Models\State;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $states = [
            ['country_id'=>'1','name'=>'Tamil Nadu'],
            ['country_id'=>'1','name'=>'Kerala'],
            ['country_id'=>'1','name'=>'Karnataka'],
            ['country_id'=>'2','name'=>'Texas'],
            ['country_id'=>'2','name'=>'California'],
            ['country_id'=>'2','name'=>'New York'],
        ];
        foreach($states as $state){
            State::create($state);
        }
    }
}
