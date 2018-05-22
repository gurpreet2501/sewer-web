<?php
use Phinx\Migration\AbstractMigration;

class UpdateStatusField extends AbstractMigration
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
      
        $contracts = Models\RateContracts::onlyTrashed()->get();
        
        foreach ($contracts as $key => $cont) {
            
            if($cont->deleted_at > '0000-00-00 00:00:00'){
                $cont->status = 'CANCELED';
                $cont->deleted_at = '0000-00-00 00:0:00';
            }
            else    
                $cont->status = 'ACTIVE';

            $cont->save();                
        }

    }
}
