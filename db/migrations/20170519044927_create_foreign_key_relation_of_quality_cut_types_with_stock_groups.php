<?php

use Phinx\Migration\AbstractMigration;

class CreateForeignKeyRelationOfQualityCutTypesWithStockGroups extends AbstractMigration
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
        $table = $this->table('quality_cut_types');
        $table->addColumn('stock_group_id', 'integer',array('null' => true, "signed" => false))
              ->addForeignKey('stock_group_id', 'stock_groups', 'id', array('delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'))
              ->save();
    }
}
