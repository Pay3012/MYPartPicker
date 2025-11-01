<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Part;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Part::insert([
            // NVIDIA RTX 50 & 40 series GPUs
            ['name' => 'RTX 5090',        'category' => 'GPU'],
            ['name' => 'RTX 5080',        'category' => 'GPU'],
            ['name' => 'RTX 5070 Ti',     'category' => 'GPU'],
            ['name' => 'RTX 5070',        'category' => 'GPU'],
            ['name' => 'RTX 5060 Ti',     'category' => 'GPU'],
            ['name' => 'RTX 5060',        'category' => 'GPU'],
            ['name' => 'RTX 5050',        'category' => 'GPU'],
            ['name' => 'RTX 4090',        'category' => 'GPU'],
            ['name' => 'RTX 5070',        'category' => 'GPU'],
            ['name' => 'RTX 5060 Ti',     'category' => 'GPU'],
            ['name' => 'RTX 5060',        'category' => 'GPU'],
            ['name' => 'RTX 5050',        'category' => 'GPU'],
            ['name' => 'RTX 4090',        'category' => 'GPU'],
            ['name' => 'RTX 4080 Super',        'category' => 'GPU'],
            ['name' => 'RTX 4080',        'category' => 'GPU'],
            ['name' => 'RTX 4070 Ti Super',     'category' => 'GPU'],
            ['name' => 'RTX 4070 Ti',     'category' => 'GPU'],
            ['name' => 'RTX 4070 Super',     'category' => 'GPU'],
            ['name' => 'RTX 4070',     'category' => 'GPU'],
            ['name' => 'RTX 4060 Ti',     'category' => 'GPU'],
            ['name' => 'RTX 4060',     'category' => 'GPU'],

            // AMD  RX 9000 & RX 7000 series GPUs
            ['name' => ' RX 9070 XT',       'category' => 'GPU'],
            ['name' => ' RX 9070',          'category' => 'GPU'],
            ['name' => ' RX 9060 XT 16GB',  'category' => 'GPU'],
            ['name' => ' RX 9060 XT 8GB',   'category' => 'GPU'],
            ['name' => ' RX 9060',          'category' => 'GPU'],  
            ['name' => ' RX 7900 XTX',       'category' => 'GPU'],
            ['name' => ' RX 7900 XT',          'category' => 'GPU'],
            ['name' => ' RX 7900 GRE',  'category' => 'GPU'],
            ['name' => ' RX 7800 XT',   'category' => 'GPU'],
            ['name' => ' RX 7700 XT',          'category' => 'GPU'],  
            ['name' => ' RX 7700',       'category' => 'GPU'],
            ['name' => ' RX 7600 XT0',          'category' => 'GPU'],
            ['name' => ' RX 7600',  'category' => 'GPU'],

            // R9000 & Ryzen 7000 series CPUs
            ['name' => 'R9 9950X3D',     'category' => 'CPU'],
            ['name' => 'R9 9900X3D',     'category' => 'CPU'],
            ['name' => 'R7 9800X3D',     'category' => 'CPU'],
            ['name' => 'R7 9700X',       'category' => 'CPU'], 
            ['name' => 'R7 9700F',       'category' => 'CPU'], 
            ['name' => 'R5 9600X',       'category' => 'CPU'],
            ['name' => 'R5 9600',       'category' => 'CPU'],
            ['name' => 'R5 9500F',       'category' => 'CPU'],
            ['name' => 'R9 7950X3D',     'category' => 'CPU'],
            ['name' => 'R9 7950X',     'category' => 'CPU'],
            ['name' => 'R9 7900X3D',     'category' => 'CPU'],
            ['name' => 'R9 7900X',     'category' => 'CPU'],
            ['name' => 'R9 7900',     'category' => 'CPU'],
            ['name' => 'R7 7800X3D',     'category' => 'CPU'],
            ['name' => 'R7 7700X',       'category' => 'CPU'], 
            ['name' => 'R7 7700',       'category' => 'CPU'],
            ['name' => 'R5 7600X',       'category' => 'CPU'], 
            ['name' => 'R5 7600',       'category' => 'CPU'], 
            ['name' => 'R5 7500F',       'category' => 'CPU'], 
            ['name' => 'R5 7400F',       'category' => 'CPU'], 
            ['name' => 'R5 7400',       'category' => 'CPU'], 

            // Ultra CPUs
            ['name' => 'Ultra 9 285K',  'category' => 'CPU'],
            ['name' => 'Ultra 9 285',   'category' => 'CPU'],
            ['name' => 'Ultra 7 265K',  'category' => 'CPU'],
            ['name' => 'Ultra 7 265KF',  'category' => 'CPU'],
            ['name' => 'Ultra 5 265',  'category' => 'CPU'], 
            ['name' => 'Ultra 5 265F',  'category' => 'CPU'], 
            ['name' => 'Ultra 5 245K',  'category' => 'CPU'], 
            ['name' => 'Ultra 5 245KF',  'category' => 'CPU'], 
            ['name' => 'Ultra 5 245',  'category' => 'CPU'],
            ['name' => 'Ultra 5 235',  'category' => 'CPU'],
            ['name' => 'Ultra 5 225',  'category' => 'CPU'],
            ['name' => 'Ultra 5 225F',  'category' => 'CPU'],
        ]);
    }
}
