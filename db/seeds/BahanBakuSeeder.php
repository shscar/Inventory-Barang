<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class BahanBakuSeeder extends AbstractSeed
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
            [ 'kode' => 'BBK001',  'nama' => 'Kayu'],
            [ 'kode' => 'BBK002',  'nama' => 'Paku'],
            [ 'kode' => 'BBK003',  'nama' => 'Kaca'],  
            [ 'kode' => 'BBK004',  'nama' => 'Aluminium'],
            [ 'kode' => 'BBK005',  'nama' => 'Karet'],
            [ 'kode' => 'BBK006',  'nama' => 'Besi']
        ];

        $now = date('Y-m-d H:i:s');
        foreach ($data as &$item) {
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
        }

        $this->table('tbl_bahan_baku')->insert($data)->saveData();
    }
}
