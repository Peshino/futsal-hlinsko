<?php

use App\Color;
use Illuminate\Support\Facades\File;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = File::get('database/data/colors.json');
        $objects = json_decode($json);
        foreach ($objects as $object) {
            Color::create([
                'name' => $object->name,
                'hex_code' => $object->hex_code,
                'rgb_code' => $object->rgb_code,
            ]);
        }
    }
}
