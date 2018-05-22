<?php

use Phinx\Migration\AbstractMigration;

class AddTransactionDateInTransactionsTbl extends AbstractMigration
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
      $table = $this->table('transactions');
      $table->addColumn('transaction_date', 'datetime',array('after' => 'transaction_type'))
              ->update();

      $trans = Models\Transactions::get();        

      foreach ($trans as $key => $v) {
        $v->transaction_date = $v->created_at;
        $v->save();
      }
   

    }
}
