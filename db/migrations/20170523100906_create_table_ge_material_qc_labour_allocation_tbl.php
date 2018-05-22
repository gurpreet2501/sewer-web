<?php

use Phinx\Migration\AbstractMigration;

class CreateTableGeMaterialQcLabourAllocationTbl extends AbstractMigration
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
        $table = $this->table('ge_material_qc_labour_allocation');
        $table->addColumn('stock_item_id', 'integer')
              ->addColumn('no_of_bags', 'integer')
              ->addColumn('godown_id', 'integer')
              ->addColumn('labour_party_id', 'integer')
              ->addColumn('quality_cut_id', 'integer')
              ->addColumn('remarks', 'text')
              ->addColumn('job_status', 'string',array('limit' => 15))
              ->addColumn('created_at', 'datetime')
              ->addColumn('updated_at', 'datetime')
              ->create();
    }
}
