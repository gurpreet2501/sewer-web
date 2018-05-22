<?php

use Phinx\Migration\AbstractMigration;

class CreateOrigIdFieldInGateEntries extends AbstractMigration
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
        $table->addColumn('orig_id', 'integer',array('after' => 'status'))
              ->update();
        
        $table = $this->table('canceled_gate_entries');
        $table->addColumn('orig_id', 'integer', array('after' => 'status'))
              ->update();
        
    }
}
