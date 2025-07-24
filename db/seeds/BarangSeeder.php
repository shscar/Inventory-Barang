<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class BarangSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                'kode' => 'BRG001',
                'nama' => 'Meja',    
                'kategori' => 'Furniture',
            ],
            [
                'kode' => 'BRG002',
                'nama' => 'Kursi',   
                'kategori' => 'Furniture',
            ],
            [
                'kode' => 'BRG003',
                'nama' => 'Jendela', 
                'kategori' => 'Bangunan', 
            ]
        ];

        $now = date('Y-m-d H:i:s');
        foreach ($data as &$item) {
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
        }

        $this->table('tbl_barang')->insert($data)->saveData();
    }
}
