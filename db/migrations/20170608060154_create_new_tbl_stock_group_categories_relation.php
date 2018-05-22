<?php

use Phinx\Migration\AbstractMigration;

class CreateNewTblStockGroupCategoriesRelation extends AbstractMigration
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
        $table = $this->table('stock_group_categories_relation');
        $table->addColumn('stock_group_id','integer')
              ->addColumn('stock_group_categories_id','integer')
              ->addColumn('created_at','datetime')
              ->addColumn('updated_at','datetime')->create();
    }
}
