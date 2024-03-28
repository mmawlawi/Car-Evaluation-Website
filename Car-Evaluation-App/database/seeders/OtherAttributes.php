<?php

namespace Database\Seeders;

use App\Models\BodyType;
use App\Models\Drivetype;
use App\Models\FuelType;
use App\Models\Transmission;
use App\Models\UsedOrNew;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\State;

class OtherAttributes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = storage_path('data_labels.json');
        $json = File::get($path);
        $data = json_decode($json, true);

        foreach($data["BodyType"] as $bodytype) {
            $bt = new BodyType();
            $bt->name = $bodytype;
            $bt->save();
        }

        foreach($data["DriveType"] as $drivetype) {
            $dt = new Drivetype();
            $dt->name = $drivetype;
            $dt->save();
        }

        foreach($data["FuelType"] as $fueltype) {
            $ft = new FuelType();
            $ft->name = $fueltype;
            $ft->save();
        }

        $transmission = ['Manual' , 'Automatic'];
        foreach($transmission as $tr) {
            $tra = new Transmission();
            $tra->name = $tr;
            $tra->save();
        }

        $used_or_new = ['USED' , 'NEW' , 'DEMO'];
        foreach($used_or_new as $uon) {
            $u = new UsedOrNew();
            $u->name = $uon;
            $u->save();
        }

        $states = ['ACT' , 'AU-VIC' , 'NSW' , 'NT' , 'QLD' , 'SA' , 'TAS' , 'VIC' , 'WA'];
        foreach($states as $state) {
            $s = new State();
            $s->name = $state;
            $s->save();
        }
    }
}
