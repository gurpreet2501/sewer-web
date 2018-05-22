<?php

use Phinx\Migration\AbstractMigration;

class ImportAccountsTblData extends AbstractMigration
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
        
        $acc = Models\Accounts::get();
       
        $filePath = __DIR__."/../../storage/accounts.csv";
        $file = fopen($filePath,"r");
        $i = 0;
        try{

            while(! feof($file))
              {
                
                if($i==0 | $i==1){
                    $i++;
                    continue;
                } 
               
                $line =  fgetcsv($file);

                $t = Models\Accounts::create([
                       'name' => $line[0], 
                       'accounts_group_id' => $line[1], 
                    ]);
              }
        
          }catch(Exception $e){
            echo $t;
          }
    }
}
