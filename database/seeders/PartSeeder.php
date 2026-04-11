<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Part;

class PartSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Part::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $this->seedFromCsv('cpu', 'CPU', fn($r) => [
            'core_count'        => $r['core_count']        ?: null,
            'core_clock'        => $r['core_clock']        ?: null,
            'boost_clock'       => $r['boost_clock']       ?: null,
            'microarchitecture' => $r['microarchitecture'] ?: null,
            'tdp'               => $r['tdp']               ?: null,
            'graphics'          => $r['graphics']          ?: null,
        ]);

        $this->seedFromCsv('gpu', 'GPU', fn($r) => [
            'chipset'     => $r['chipset']     ?: null,
            'memory'      => $r['memory']      ?: null,
            'core_clock'  => $r['core_clock']  ?: null,
            'boost_clock' => $r['boost_clock'] ?: null,
            'color'       => $r['color']       ?: null,
            'length'      => $r['length']      ?: null,
        ]);

        $this->seedFromCsv('motherboard', 'Motherboard', fn($r) => [
            'socket'        => $r['socket']        ?: null,
            'form_factor'   => $r['form_factor']   ?: null,
            'max_memory'    => $r['max_memory']    ?: null,
            'memory_slots'  => $r['memory_slots']  ?: null,
            'color'         => $r['color']         ?: null,
        ]);

        $this->seedFromCsv('ram', 'RAM', fn($r) => [
            'speed'              => $r['speed']              ?: null,
            'modules'            => $r['modules']            ?: null,
            'color'              => $r['color']              ?: null,
            'first_word_latency' => $r['first_word_latency'] ?: null,
            'cas_latency'        => $r['cas_latency']        ?: null,
        ]);

        $this->seedFromCsv('storage', 'Storage', fn($r) => [
            'capacity'     => $r['capacity']     ?: null,
            'type'         => $r['type']         ?: null,
            'cache'        => $r['cache']        ?: null,
            'form_factor'  => $r['form_factor']  ?: null,
            'interface'    => $r['interface']    ?: null,
        ]);

        $this->seedFromCsv('psu', 'PSU', fn($r) => [
            'type'       => $r['type']       ?: null,
            'efficiency' => $r['efficiency'] ?: null,
            'wattage'    => $r['wattage']    ?: null,
            'modular'    => $r['modular']    ?: null,
            'color'      => $r['color']      ?: null,
        ]);

        $this->seedFromCsv('cooler', 'Cooler', fn($r) => [
            'rpm'         => $r['rpm']         ?: null,
            'noise_level' => $r['noise_level'] ?: null,
            'color'       => $r['color']       ?: null,
            'size'        => $r['size']        ?: null,
        ]);

        $this->seedFromCsv('fan', 'Fan', fn($r) => [
            'size'        => $r['size']        ?: null,
            'color'       => $r['color']       ?: null,
            'rpm'         => $r['rpm']         ?: null,
            'airflow'     => $r['airflow']     ?: null,
            'noise_level' => $r['noise_level'] ?: null,
            'pwm'         => $r['pwm']         ?: null,
        ]);

        $this->seedFromCsv('case', 'Case', fn($r) => [
            'type'               => $r['type']               ?: null,
            'color'              => $r['color']              ?: null,
            'psu'                => $r['psu']                ?: null,
            'side_panel'         => $r['side_panel']         ?: null,
            'external_volume'    => $r['external_volume']    ?: null,
            'internal_35_bays'   => $r['internal_35_bays']   ?: null,
        ]);
    }

    private function seedFromCsv(string $type, string $category, callable $specsMapper): void
    {
        $path = database_path("data/{$type}.csv");
        $handle = fopen($path, 'r');
        $headers = fgetcsv($handle);

        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($headers, $row);
            Part::create([
                'type'     => $type,
                'category' => $category,
                'name'     => $data['name'],
                'price'    => $data['price'] !== '' ? round($data['price'] * 4, 2) : null,
                'specs'    => $specsMapper($data),
            ]);
        }

        fclose($handle);
    }
}
