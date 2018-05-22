<?php

use Phinx\Migration\AbstractMigration;

class CreateOrigIdFieldInCanceledGateEntriesTables extends AbstractMigration
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
            $tables = [
            'canceled_ge_bag_types',
            'canceled_ge_cmr_details',
            'canceled_ge_cmr_rice_delivery_details',
            'canceled_ge_delivery_details',
            'canceled_ge_delivery_qc',
            'canceled_ge_godown_labor_allocation',
            'canceled_ge_material_qc_labour_allocation',
            'canceled_ge_quality_cut',
            'canceled_ge_stock_items',
        ];

        foreach ($tables as $key => $tab) {
            $table = $this->table($tab);
            $table->addColumn('orig_id', 'integer')
            ->update();
        }
    }
}
