<?php

use Phinx\Migration\AbstractMigration;

class UpdateGateEntryTable extends AbstractMigration
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
        $table = $this->table('gate_entries');
       
        if($table->hasColumn('material_in_stock_group'))
            $table->removeColumn('material_in_stock_group');

        if($table->hasColumn('material_out_stock_group'))
            $table->removeColumn('material_out_stock_group');

        $table->save();

        if($table->hasColumn('entry_type')){
            $table->removeColumn('entry_type');
        }

        if($table->hasColumn('form_id')){
            $table->removeColumn('form_id');
        }
        if($table->hasColumn('stock_group_id')){
            $table->removeColumn('stock_group_id');
        }
       
        $table->addColumn('entry_type', 'string', 
                    array('after' => 'id','length'=> 5));

        $table->addColumn('form_id', 'integer', 
                            ['after'    => 'entry_type', 
                            'null'      => true,
                            'length'    => 11]);

        $table->addForeignKey('form_id', 'forms', 'id');

        $table->addColumn('stock_group_id', 'integer', 
                            ['after'    => 'form_id',
                            'null'      => true,
                            'signed'    => false,
                            'length'    => 10]);

        $table->addForeignKey('stock_group_id', 'stock_groups', 'id')
              ->update();
    }
}
