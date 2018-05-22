<?php

use Phinx\Migration\AbstractMigration;

class AddOtherLabourJobsTbl extends AbstractMigration
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
        $table = $this->table('other_labour_jobs');
        $table->addColumn('job_type_id', 'integer')
              ->addColumn('godown_id', 'integer')
              ->addColumn('weight', 'decimal', array('scale' => 2,'precision' => 10))
              ->addColumn('weight_unit', 'integer')
              ->addColumn('party_id', 'integer')
              ->addColumn('date', 'datetime')
              ->create();
    }
}
