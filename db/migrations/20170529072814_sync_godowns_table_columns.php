<?php

use Phinx\Migration\AbstractMigration;

class SyncGodownsTableColumns extends AbstractMigration
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
        $godowns = $this->table('godowns');

        if(!$godowns->hasColumn('Alias'))
            $godowns->addColumn('Alias', 'string',array('null' => true, "length" => 5));

        if(!$godowns->hasColumn('godown_type'))
            $godowns->addColumn('godown_type', 'string',array('null' => true, "length" => 16));

        $godowns->save();

    }
}
