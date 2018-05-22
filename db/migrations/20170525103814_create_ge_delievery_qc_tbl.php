<?php

use Phinx\Migration\AbstractMigration;

class CreateGeDelieveryQcTbl extends AbstractMigration
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
        $table = $this->table("ge_delivery_qc");
        $table->addColumn('gate_entry_id', 'integer', array('null' => true, "signed" => false))
              ->addColumn('qc_type_id',  'integer')
              ->addColumn('quantity_per_unit', 'decimal', array('precision' => 10,'scale' => 2))
              ->addColumn('cut_unit', 'string', array('limit' => 10))
              ->addColumn('unit_count', 'decimal', array('precision' => 10,'scale' => 2))
              ->addColumn('updated_at', 'datetime')
              ->addColumn('created_at', 'datetime')
              ->create();
        $table->addForeignKey('gate_entry_id', 'gate_entries', 'id')
              ->save();       
    }
}
