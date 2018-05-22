<?php

use Phinx\Migration\AbstractMigration;

class AddTypeToRateContracts extends AbstractMigration
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
        $rc = Models\RateContracts::with('contractsStockItems')->get();
        foreach ($rc as $key => $cont) {
            if(count($cont->contractsStockItems) == 0)
                continue;
            
            if($cont->contractsStockItems[0]->weight > 0)
                $cont->type = 'QUANTITY';
            else
                $cont->type = 'BY_END_DATE';

            $cont->save();
            
        }
    }
}
