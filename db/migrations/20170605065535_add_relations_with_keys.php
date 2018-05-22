<?php

use Phinx\Migration\AbstractMigration;

class AddRelationsWithKeys extends AbstractMigration
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
        $transactions = $this->table('transactions'); 
        
        $transactions->dropForeignKey('primary_account_id')
                     ->dropForeignKey('secondary_account_id')->save();

        $transactions
            ->removeColumn('primary_account_id')
            ->removeColumn('secondary_account_id')->save();
              
        $transactions->addColumn('primary_account_id', 'integer', ['null' => true, 'length' => 11])
            ->addColumn('secondary_account_id', 'integer', ['null' => true, 'length' => 11])
            ->addForeignKey('primary_account_id','accounts', 'id')
            ->addForeignKey('secondary_account_id','accounts', 'id')
            ->save();

        $machinery_parts = $this->table('machinery_parts'); 
        if($machinery_parts->hasColumn('party_id'))
            $machinery_parts->removeColumn('party_id')->save();

        
        if($machinery_parts->hasColumn('account_id')){
            $machinery_parts->dropForeignKey('account_id')
                            ->removeColumn('account_id')->save();
        }

        $machinery_parts
            ->addColumn('account_id', 'integer', ['null' => true, 'length' => 11])
            ->addForeignKey('account_id','accounts', 'id')
            ->save();
        $this->query('SET foreign_key_checks = 1;');
    }
}
