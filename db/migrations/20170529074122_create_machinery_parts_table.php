<?php

use Phinx\Migration\AbstractMigration;

class CreateMachineryPartsTable extends AbstractMigration
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
        $table = $this->table('machinery_parts');
        $table
                ->addColumn('date', 'date')
                ->addColumn('godown_id', 'integer')
                ->addColumn('party_id', 'integer')
                ->addColumn('invoice_num', 'string', array('limit' => 100))
                ->addColumn('amount', 'decimal', array('precision' => 10,'scale' => 2))              
                ->addColumn('material_description', 'string', array('limit' => 250))
                ->addColumn('bill_image', 'string', array('limit' => 250))
                ->addColumn('created_at','datetime')
                ->addColumn('updated_at', 'datetime')
                ->create();
    }
}
