<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaction;

class TransactionSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Bensin', 'Makan Siang', 'Belanja Bulanan', 'Gaji Bulan Mei', 
            'Sedekah Mingguan', 'Internet', 'Listrik', 'Air', 'Kopi', 'Jajan'
        ];

        for ($i = 0; $i < 50; $i++) {
            Transaction::create([
                'category_id' => rand(1, 5),
                'name' => $names[array_rand($names)],
                'amount' => rand(10000, 500000),
                'date' => now()->subDays(rand(0, 30)),
                'note' => null,
                'image' => null,
            ]);
        }
    }
}
