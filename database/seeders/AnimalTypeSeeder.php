<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AnimalType;

class AnimalTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'id' => 1,
                'name' => 'ねこ',
            ],
            [
                'id' => 2,
                'name' => 'いぬ',
            ],
            [
                'id' => 3,
                'name' => 'ごりら',
            ],
        ];
        foreach ($datas as $key => $value) {
            $animalType = new AnimalType();
            $animalType->id = $value['id'];
            $animalType->name = $value['name'];
            $animalType->save();
            # code...
        }
    }
}
