<?php

use Phinx\Migration\AbstractMigration;

class RenamePaymentTables extends AbstractMigration
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
        $table = $this->table('labor_payments_ge_godown_labor_allocation_relation');
        $table->rename('labor_payments_ge_material_qc_labour_allocation_relation');
        $table = $this->table('labor_payments_ge_material_qc_labour_allocation_relation');
        $table->renameColumn('ge_godown_labor_allocation_id', 'ge_material_qc_labour_allocation_id');
    }
}
