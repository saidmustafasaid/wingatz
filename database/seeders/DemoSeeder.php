<?php

namespace Database\Seeders;

use App\Models\Bidhaa;
use App\Models\Mteja;
use App\Models\Uuzaji;
use App\Models\Swali;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // Bidhaa za demo
        $bidhaa_data = [
            ['jina' => 'Samsung Galaxy A15', 'bei_halisi' => 320000, 'bei_yangu' => 390000, 'kategoria' => 'Simu', 'hali' => 'inapatikana'],
            ['jina' => 'iPhone 13 Pro', 'bei_halisi' => 1500000, 'bei_yangu' => 1800000, 'kategoria' => 'Simu', 'hali' => 'inapatikana'],
            ['jina' => 'Redmi Note 13', 'bei_halisi' => 250000, 'bei_yangu' => 310000, 'kategoria' => 'Simu', 'hali' => 'imeuzwa'],
            ['jina' => 'Airpods Pro', 'bei_halisi' => 180000, 'bei_yangu' => 240000, 'kategoria' => 'Elektroniki', 'hali' => 'inapatikana'],
            ['jina' => 'Laptop HP i5', 'bei_halisi' => 750000, 'bei_yangu' => 900000, 'kategoria' => 'Kompyuta', 'hali' => 'imeuzwa'],
            ['jina' => 'Smartwatch Huawei', 'bei_halisi' => 120000, 'bei_yangu' => 160000, 'kategoria' => 'Elektroniki', 'hali' => 'inapatikana'],
            ['jina' => 'Bluetooth Speaker JBL', 'bei_halisi' => 85000, 'bei_yangu' => 120000, 'kategoria' => 'Elektroniki', 'hali' => 'imeuzwa'],
            ['jina' => 'Powerbank 20000mAh', 'bei_halisi' => 45000, 'bei_yangu' => 70000, 'kategoria' => 'Elektroniki', 'hali' => 'inapatikana'],
        ];

        $bidhaa_list = [];
        foreach ($bidhaa_data as $data) {
            $bidhaa_list[] = Bidhaa::create($data);
        }

        // Wateja wa demo
        $wateja_data = [
            ['jina' => 'Amina Hassan', 'simu' => '0712345678', 'whatsapp' => '0712345678'],
            ['jina' => 'Juma Mwangi', 'simu' => '0765432109', 'whatsapp' => '0765432109'],
            ['jina' => 'Fatuma Said', 'simu' => '0698765432'],
            ['jina' => 'Ali Bakari', 'whatsapp' => '0756789012'],
            ['jina' => 'Zainab Omar', 'simu' => '0745678901'],
        ];

        $wateja_list = [];
        foreach ($wateja_data as $data) {
            $wateja_list[] = Mteja::create($data);
        }

        // Mauzo ya demo
        $mauzo_data = [
            ['bidhaa' => 2, 'mteja' => 0, 'bei' => 390000, 'siku' => 7, 'tarehe' => Carbon::now()->subMonths(5)->format('Y-m-d')],
            ['bidhaa' => 4, 'mteja' => 1, 'bei' => 900000, 'siku' => 14, 'tarehe' => Carbon::now()->subMonths(4)->format('Y-m-d')],
            ['bidhaa' => 6, 'mteja' => 2, 'bei' => 120000, 'siku' => 3, 'tarehe' => Carbon::now()->subMonths(3)->format('Y-m-d')],
        ];

        foreach ($mauzo_data as $m) {
            $b = $bidhaa_list[$m['bidhaa']];
            Uuzaji::create([
                'bidhaa_id' => $b->id,
                'mteja_id' => $wateja_list[$m['mteja']]->id,
                'bei_halisi' => $b->bei_halisi,
                'bei_iliyouzwa' => $m['bei'],
                'faida' => $m['bei'] - $b->bei_halisi,
                'siku_za_kuuza' => $m['siku'],
                'tarehe_ya_uuzaji' => $m['tarehe'],
            ]);
        }

        // Maswali ya demo
        Swali::create(['mteja_id' => $wateja_list[3]->id, 'bidhaa_id' => $bidhaa_list[0]->id, 'ujumbe' => 'Bei ni ngapi?', 'hali' => 'inasubiri']);
        Swali::create(['mteja_id' => $wateja_list[4]->id, 'bidhaa_id' => $bidhaa_list[3]->id, 'ujumbe' => 'Je ipo?', 'hali' => 'inasubiri']);
        Swali::create(['mteja_id' => $wateja_list[1]->id, 'bidhaa_id' => $bidhaa_list[5]->id, 'ujumbe' => 'Naomba picha', 'hali' => 'imekimbia']);
    }
}
