<?php

use Phinx\Migration\AbstractMigration;

class DeleteStockGroupIdFromBagTypes extends AbstractMigration
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
         $table = $this->table('bag_types');
        $column1 = $table->hasColumn('stock_group_id');
        $column2 = $table->hasColumn('_deadstock_group_id');
        
        if($column1)
            $table->dropForeignKey('stock_group_id')
                  ->removeColumn('stock_group_id'); 

        if($column2)          
            $table->dropForeignKey('_deadstock_group_id')
                  ->removeColumn('_deadstock_group_id'); 
    }
}
