<?php

use Phinx\Migration\AbstractMigration;

class CreateTableStockLog extends AbstractMigration
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
        $table = $this->table('stock_log');
        $table->addColumn('stock_item_id','integer')
              ->addColumn('stock','decimal', array('precision' => 10,'scale' =>2,'after' => 'stock_group_id'))
              ->addColumn('created_at','datetime')->create();
    }
}
