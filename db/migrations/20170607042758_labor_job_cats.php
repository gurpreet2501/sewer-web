<?php

use Phinx\Migration\AbstractMigration;

class LaborJobCats extends AbstractMigration
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
        $table = $this->table('labour_job_types');
        if (!$table->hasColumn('labour_job_category_id'))
        {
            $table->addColumn('labour_job_category_id', 'integer',array('after' => 'id','null'  => true))
              ->addForeignKey('labour_job_category_id', 
                               'labour_job_categories', 
                               'id',
                         array('delete'=> 'SET_NULL'))
              ->update();
        }

    }
}
