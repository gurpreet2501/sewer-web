<?php
use Phinx\Migration\AbstractMigration;

class AddEntriesInAccountCategoriesTb extends AbstractMigration
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
        // $table = $this->table('account_categories');
        if($this->hasTable('account_categories'))
            $this->dropTable('account_categories');

        $table = $this->table('account_categories');
        $table->addColumn('name','string', array('limit' => 100))->create();

        Models\AccountCategories::create(['name' => 'Labour Party']);
        Models\AccountCategories::create(['name' => 'Gate Entry Party']);
        $this->query('SET foreign_key_checks = 1;');
    }
}
