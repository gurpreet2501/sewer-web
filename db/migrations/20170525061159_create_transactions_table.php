<?php

use Phinx\Migration\AbstractMigration;

class CreateTransactionsTable extends AbstractMigration
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
        $table = $this->table('accounts');
        $table->addColumn('account_type',  'string', array('limit' => 15))
              ->addColumn('name',  'string', array('limit' => 15))
              ->addColumn('created_at', 'datetime')
              ->addColumn('updated_at', 'datetime')
              ->create();


        $table = $this->table('transactions');
        $table->addColumn('entry_type', 'string', array('limit' => 15))
              ->addColumn('transaction_type', 'string', array('limit' => 15))
              ->addColumn('account_id', 'integer')
              ->addForeignKey('account_id', 'accounts', 'id', array('delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'))
              ->addColumn('created_at', 'datetime')
              ->addColumn('updated_at', 'datetime')
              ->create();
    }
}
