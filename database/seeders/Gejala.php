<?php

namespace Database\Seeders;

use App\Models\Gejala as ModelsGejala;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Gejala extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //prefix
        //name
        //image

        //Gejala
        ModelsGejala::create([
            'name' => 'Kontak serumah',
            'image' => 'kontakserumah.jpg',
        ]);

        ModelsGejala::create([
            'name' => 'Batuk',
            'image' => 'batuk.jpg',
        ]);

        ModelsGejala::create([
            'name' => 'Sesak napas',
            'image' => 'sesaknapas.jpg',
        ]);

        ModelsGejala::create([
            'name' => 'Berkeringat malam hari tanpa kegiatan',
            'image' => 'keringat.jpg',
        ]);

        ModelsGejala::create([
            'name' => 'Demam meriang > 1 bulan',
            'image' => 'demam.jpg',
        ]);

        //faktor resiko
        ModelsGejala::create([
            'name' => 'Ibu hamil',
            'image' => 'hamil.jpg',
        ]);

        ModelsGejala::create([
            'name' => 'Lansia > 60 tahun',
            'image' => 'lansia.jpg',
        ]);

        ModelsGejala::create([
            'name' => 'Diabetes Melitus',
            'image' => 'diabetes.webp',
        ]);

        ModelsGejala::create([
            'name' => 'Perokok',
            'image' => 'perokok.jpg',
        ]);

        ModelsGejala::create([
            'name' => 'Pernah berobat TBC tapi tidak tuntas',
            'image' => 'berobat.jpg',
        ]);


      
    }
}
