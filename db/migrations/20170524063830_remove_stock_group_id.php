<?php

use Phinx\Migration\AbstractMigration;

class RemoveStockGroupId extends AbstractMigration
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
  
        $table = $this->table('gate_entry_config');
        $table->addColumn('form_id', 'integer', array('null' => true, "signed" => false))->save();
        // $table->addForeignKey('form_id', 'forms', 'id', array('delete'=> 'NO_ACTION', 'update'=> 'NO_ACTION'))->save();
        
        if($table->hasColumn('stock_group_id'))
            $table->dropForeignKey('stock_group_id')->removeColumn('stock_group_id');

    }
}
