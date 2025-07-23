<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class TblBahanBaku extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $this->table('bahan_baku')
            ->addColumn('kode', 'string')
            ->addColumn('nama', 'string')
            ->addColumn('stok', 'integer')
            ->addColumn('harga', 'decimal', ['precision' => 10, 'scale' => 2])
            ->addColumn('supplier', 'string')
            ->addColumn('barang_id', 'integer', ['signed' => true])
            ->addForeignKey('barang_id', 'tbl_barang', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            // ->addForeignKey('barang_id', 'barang', 'id', ['delete' => 'SET_NULL', 'update' => 'NO_ACTION'])
            ->addColumn('barang_kode', 'string')
            ->addForeignKey('barang_kode', 'barang', 'kode')
            ->addTimestamps()
            ->create();
    }
}