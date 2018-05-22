<?php

use Phinx\Migration\AbstractMigration;

class UpdateLabourJobsTables extends AbstractMigration
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


        $this->table('labour_job_categories')
              ->addColumn('account_id','integer', ['null' => true, 'length' => 11, 'after' => 'name'])
              ->addForeignKey('account_id','accounts', 'id')
              ->save();



        if (!$this->table('labour_job_types')->hasColumn('labour_job_category_id'))
        {
          $this->table('labour_job_types')
              ->addColumn('labour_job_category_id','integer', ['null' => true, 'length' => 11, 'after' => 'job_description'])
              ->addForeignKey('labour_job_category_id','labour_job_categories', 'id')
              ->save();
        }
    }
}
