<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $supliers = [
            ['name'=>'BookWala','email'=>'bookwala@gmail.com','contact'=>'9087654321'],
            ['name'=>'UsedBooks','email'=>'usedBooks@gmail.com','contact'=>'9876543210'],
            ['name'=>'AbcBooks','email'=>'abcbooks@gmail.com','contact'=>'8907654321'],
            ['name'=>'ModernBooks','email'=>'modern@books.edu','contact'=>'7890123456'],
            ['name'=>'Jeyagaanthan','email'=>'jeyagaantan@gmail.com','contact'=>'9012345678'],
            ['name'=>'Bharathi','email'=>'bharathi@gmail.com','contact'=>'8709654321'],
        ];

        foreach($supliers as $suplier){
            Supplier::create($suplier);
        }
    }
}
