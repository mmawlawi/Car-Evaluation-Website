<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\Attributes;
use Database\Seeders\Cars;
use Database\Seeders\Images;
use Database\Seeders\OtherAttributes;


class DatabaseSeeder extends Seeder
{
/**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Call other seeders to seed the database
        $this->call(OtherAttributes::class);
        $this->call(Attributes::class);
        $this->call(Cars::class);
        $this->call(Images::class);
        
    }
}
