<?php

use Phinx\Migration\AbstractMigration;

class CmrMarkets extends AbstractMigration
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
        if($this->hasTable('cmr_markets'))
            $this->dropTable('cmr_markets');

        $this->table('cmr_markets')
              ->addColumn('name', 'string', array('limit' => 24))
              ->addColumn('cmr_society_id', 'integer', array('limit' => 3))
              ->addColumn('address', 'string', array('limit' => 10))
              ->addColumn('market_id', 'string', array('limit' => 16))       
              ->addColumn('created_at', 'datetime')       
              ->addColumn('updated_at', 'datetime')
              ->save();

    }
}
