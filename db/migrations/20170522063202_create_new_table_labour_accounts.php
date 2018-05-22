<?php

use Phinx\Migration\AbstractMigration;

class CreateNewTableLabourAccounts extends AbstractMigration
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
        $table = $this->table('labour_accounts');
        $table->addColumn('job_title', 'string' , array('limit' => 100))
               ->addColumn('rate', 'decimal', array('precision' => 10,'scale' => 2))
               ->addColumn('p1', 'integer')
               ->addColumn('p2', 'integer')
               ->addColumn('p3', 'integer')
               ->addColumn('amount', 'integer')
               ->addColumn('created_at', 'datetime')
               ->addColumn('updated_at', 'datetime')
               ->create();
    }
}
