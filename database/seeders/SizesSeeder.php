<?php

namespace Database\Seeders;

use App\Models\Size;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SizesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rows = [            
            [
                'name' => 'S',
            ],
            [
                'name' => 'M',
            ],
            [
                'name' => 'L',
            ],
            [
                'name' => 'XL',
            ],
        ];

        foreach ($rows as $row) {
            Size::create($row);
        }
    }
}
