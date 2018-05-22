<?php

use Phinx\Migration\AbstractMigration;

class ModifyPreviousSavedRatesInQcLaborAlloc extends AbstractMigration
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
        $entries = Models\GEGodownQcLaborAllocation::get();
        foreach ($entries as $key => $entry) {
            if(empty($entry->labour_party_id) || empty($entry->labour_job_type_id))
                continue;
            $rates = Models\LabourPartyJobTypes::where('account_id', $entry->labour_party_id)
                                ->where('labour_job_type_id', $entry->labour_job_type_id)->first();
            
            $entry->rate = $rates->rate;
            $entry->save();

        }
    }
}
