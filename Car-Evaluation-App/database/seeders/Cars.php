<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Cars extends Seeder
{
    public function run(): void
    {
        $path = storage_path('Modified Australian Vehicle Prices.csv');
        $file = fopen($path, 'r');
        $header = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            $rowData = array_combine($header, $row);
            
        }
    }
}
