<?php

use Phinx\Migration\AbstractMigration;

class GeCmrDetailsMarketId extends AbstractMigration
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
        $this->table('ge_cmr_details')
                ->addColumn('cmr_market_id', 
                        'integer', 
                        array(  'after' => 'cmr_agency_id',
                                'null'=>true,
                                'limit'=>11))
                ->addForeignKey('cmr_market_id', 'cmr_markets', 'id')
                ->save();
    }
}
