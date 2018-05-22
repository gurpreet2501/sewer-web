<?php

use Phinx\Migration\AbstractMigration;

class CreateWeightUnitsTbl extends AbstractMigration
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
        $table = $this->table('weight_units');
        $table->addColumn('name','string',array('limit' => 10))
              ->addColumn('created_at','datetime')
              ->addColumn('updated_at','datetime')->create();
        $data = ['QUINTAL','BAG','KILOGRAM','GRAM'];

        foreach($data as $v){
            $table->insert(['name' => $v]);
        }

        $table->saveData();

    }
}
