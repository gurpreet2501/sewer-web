<?php

use Phinx\Migration\AbstractMigration;

class LabourTableUpdates extends AbstractMigration
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
        $this->dropTable('labour_accounts');
        $table = $this->table('labour_job_categories')->addColumn('name', 'string', array('limit' => 250))->create();
        $table = $this->table('labour_partes')->addColumn('name','string' , array('limit' => 250))->create(); 

        $table = $this->table('labour_accounts');
        $table->addColumn('job_title', 'string' , array('limit' => 100))
              ->addColumn('job_description', 'text')
              ->addColumn('labour_job_category_id', 'integer')
              ->addColumn('p1', 'integer')
              ->addColumn('p2', 'integer')
              ->addColumn('p3', 'integer')
              ->addColumn('amount', 'integer')
              ->addColumn('created_at', 'datetime')
              ->addColumn('updated_at', 'datetime')
              ->addForeignKey('labour_job_category_id', 'labour_job_categories', 'id', array('delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'))
              ->create();


        $table = $this->table('labour_party_job_rates')
                  ->addColumn('labour_account_id', 'integer')
                  ->addColumn('labour_party_id', 'integer')
                  ->addForeignKey('labour_account_id', 'labour_accounts', 'id', array('delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'))
                  ->addForeignKey('labour_party_id', 'labour_partes', 'id', array('delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'))
                  ->addColumn('rate', 'decimal', array('precision' => 10,'scale' => 2))
                  ->create();

    }
}
