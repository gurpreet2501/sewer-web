<?php

use Phinx\Migration\AbstractMigration;

class ModeLabourPartiesToAccounts extends AbstractMigration
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
        $accCat = Models\AccountCategories::where('name','Labour Party')->first();
        
        $accountCatId = $accCat->id;


        $labourParties = Models\LabourParties::get();
        
        foreach($labourParties as $party){
            if(empty($party->name))
                continue;
            $account = Models\Accounts::create(['name' => $party->name]);
            Models\AccountCategoriesRelation::create(['account_id' => $account->id, 'account_category_id' => $accountCatId]);

        }

    }
}
