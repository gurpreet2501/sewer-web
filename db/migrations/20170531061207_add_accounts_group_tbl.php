<?php

use Phinx\Migration\AbstractMigration;
use Illuminate\Database\Capsule\Manager as DB;
class AddAccountsGroupTbl extends AbstractMigration
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
        if($this->hasTable('accounts_group'))
            $this->dropTable('accounts_group');    
        $accounts_category = $this->table('accounts_category');
        $accounts_category->changeColumn('id', 'integer')
              ->save();

        $table = $this->table('accounts_group');
        $table->addColumn('name','string' ,array('limit' => 32))
              ->addColumn('group_id','integer')
              ->addColumn('category_id','integer')
              ->addForeignKey('category_id', 'accounts_category', 'id')
              ->create();

        $file = __DIR__.'/../../storage/accounts_group.sql';
        $content = file_get_contents($file);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $res = DB::select($content);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    
    }
}
