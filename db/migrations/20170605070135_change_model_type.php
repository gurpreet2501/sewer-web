<?php

use Phinx\Migration\AbstractMigration;

class ChangeModelType extends AbstractMigration
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
         $table = $this->table('form_modules');
         $exists = $this->hasTable('form_modules');
         if($exists)
             $table->changeColumn('module_id', 'string', array('limit' => 70))->save();
    }
}
