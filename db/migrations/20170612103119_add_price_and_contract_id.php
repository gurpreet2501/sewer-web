<?php

use Phinx\Migration\AbstractMigration;

class AddPriceAndContractId extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('ge_stock_items')
             ->addColumn('rate_contract_id', 'integer', ['null' => true, 'length' => 11])
             ->addColumn('rate', 'decimal', ['precision' => 10, 'scale' => 2])
             ->addForeignKey('rate_contract_id', 'rate_contracts', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])->save();

        $this->table('ge_material_qc_labour_allocation')
            ->addColumn('rate_contract_id', 'integer', ['null' => true, 'length' => 11])
            ->addColumn('rate', 'decimal', array('precision' => 10, 'scale' => 2))
            ->addForeignKey('rate_contract_id', 'rate_contracts', 'id', ['delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'])->save();
        
        
    }
}
