<?php

use Phinx\Migration\AbstractMigration;

class LabourPaymentsTable extends AbstractMigration
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
         
        $table = $this->table('labor_payments');
        $table->addColumn('ge_id', 'integer')
              ->addColumn('labour_party_id', 'integer')
              ->addColumn('amount', 'decimal',array('precision' => 10,'scale' => 2))
              ->addColumn('from_balance_amount', 'decimal',array('precision' => 10,'scale' => 2))
              ->addColumn('payment_account_id', 'integer')
              ->addColumn('created_at', 'datetime')
              ->addColumn('updated_at', 'datetime')
              ->create();
    }
}
