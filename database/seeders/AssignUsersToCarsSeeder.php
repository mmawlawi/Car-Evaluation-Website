<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\User;
class AssignUsersToCarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::pluck('id')->all();
        $cars = Car::all();

        foreach ($cars as $car) {
            $car->user_id = $userIds[array_rand($userIds)]; // Randomly pick a user ID
            $car->save(); // Save the car with the new user_id
        }
    }
}
