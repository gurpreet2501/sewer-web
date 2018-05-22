<?php

use Phinx\Migration\AbstractMigration;

class UpdateAccountIdInLabourPartyJobTypes extends AbstractMigration
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
        $this->query('SET foreign_key_checks = 0;'); 
        $table = $this->table('labour_party_job_types');
        $table->addForeignKey('account_id', 'accounts', 'id')->update();
        

      
        $labParties = Models\LabourParties::get();
        
        foreach($labParties as $lparty){
            $acc = Models\Accounts::where('name', $lparty->name)->first();
            
            
            if(!count($acc))
                continue;

            $labrJobTypes = Models\LabourPartyJobTypes::where('account_id', $lparty->id)->get();
            foreach ($labrJobTypes as $key => $ljobtype) {
                $this->query("UPDATE `labour_party_job_types` SET account_id=".$acc->id." WHERE id=".$ljobtype->id."");
            }
            

            // $obj->update(['account_id' => $acc->id]);
        }
    
        $this->query('SET foreign_key_checks = 1;'); 

    }
}
