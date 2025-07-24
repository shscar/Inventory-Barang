<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class BarangBahanSeeder extends AbstractSeed
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
            ['barang_kode' => 'BRG001', 'bahan_kode' => 'BBK001'],
            ['barang_kode' => 'BRG001', 'bahan_kode' => 'BBK002'],
            ['barang_kode' => 'BRG001', 'bahan_kode' => 'BBK003'],
            ['barang_kode' => 'BRG002', 'bahan_kode' => 'BBK006'],
            ['barang_kode' => 'BRG002', 'bahan_kode' => 'BBK001'],
            ['barang_kode' => 'BRG003', 'bahan_kode' => 'BBK004'],
            ['barang_kode' => 'BRG003', 'bahan_kode' => 'BBK003'],
            ['barang_kode' => 'BRG003', 'bahan_kode' => 'BBK005']
        ];

        $this->table('tbl_barang_bahan')->insert($data)->saveData();
    }
}
