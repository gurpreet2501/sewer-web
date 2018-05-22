<?php

use Phinx\Migration\AbstractMigration;

class CreateRateContracts extends AbstractMigration
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
        $this->table('rate_contracts')
              ->addColumn('name', 'string', array('limit' => 24))
              ->addColumn('from_date', 'date', array('null' => true))
              ->addColumn('to_date', 'date', array('null' => true))
              ->addColumn('account_id', 'integer')
              ->addColumn('weight', 'decimal', array('precision' => 10,'scale' => 2))
              ->addColumn('unit', 'string', array('limit' => 24))    
              ->addColumn('created_at', 'datetime')       
              ->addColumn('updated_at', 'datetime')
              ->save();

       $this->table('rate_contract_stock_items')
              ->addColumn('contract_id', 'integer')
              ->addColumn('stock_item_id', 'integer')
              ->addColumn('rate', 'decimal', array('precision' => 10,'scale' => 2))       
              ->addColumn('created_at', 'datetime')       
              ->addColumn('updated_at', 'datetime')
              ->save();
    }
}
