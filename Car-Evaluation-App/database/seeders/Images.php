<?php

namespace Database\Seeders;

use App\Models\CarModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class Images extends Seeder
{
    public function run(): void
    {
        $path = storage_path('car-images.json');
        $json = File::get($path);
        $data = json_decode($json, true);

        foreach ($data as $brand => $models) {
            foreach ($models as $model => $links) {
                $carModel = CarModel::where('name', $model)->first();

                if ($carModel) {
                    $carModel->update([
                        'photo_link_1' => isset($links[0]) ? $links[0] : null,
                        'photo_link_2' => isset($links[1]) ? $links[1] : null,
                        'photo_link_3' => isset($links[2]) ? $links[2] : null,
                    ]);
                } 
            }
        }
    }
}
