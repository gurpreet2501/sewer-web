<?php

use Phinx\Migration\AbstractMigration;

class AddCmrAgencyId extends AbstractMigration
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
        $table = $this->table('ge_cmr_details');
        $table->addColumn('cmr_agency_id', 'integer', array(
            'after' => 'ge_id',
            'null' => true,
            'limit'=> 11,
            'signed' => false
        ));
        $table->save();
        $table = $this->table('canceled_ge_cmr_details');
        $table->addColumn('cmr_agency_id', 'integer', array(
            'after' => 'ge_id',
            'null' => true,
            'limit'=> 11,
            'signed' => false
        ));
        $table->save();



        // `cmr_agency_id` int(10) UNSIGNED NOT NULL,


        // $table = $this->table('canceled_ge_cmr_details');
        //  $table->->addColumn('cmr_market_id', 'integer', array(
        //     'after' => 'ge_id',
        //     'null' => true,
        //     'limit'=> 11,
        //     'signed' => false
        // ));
        // $table->save();
    // }

    }
}
