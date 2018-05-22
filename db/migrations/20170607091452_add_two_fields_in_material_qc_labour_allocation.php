<?php

use Phinx\Migration\AbstractMigration;

class AddTwoFieldsInMaterialQcLabourAllocation extends AbstractMigration
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
        $table = $this->table('ge_material_qc_labour_allocation');
        $table->addColumn('rate_per_unit','string',array('limit' => 5,'after' => 'labour_job_type_id','default' => NULL))
              ->addColumn('weight_unit','string', array('limit' => 5, 'after' => 'labour_job_type_id','default' => NULL))->save();

    }
}
