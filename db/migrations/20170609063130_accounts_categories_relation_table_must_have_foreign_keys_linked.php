<?php

use Phinx\Migration\AbstractMigration;

class AccountsCategoriesRelationTableMustHaveForeignKeysLinked extends AbstractMigration
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
        $this->table('accounts_categories_relation')
              // ->addColumn('account_category_id','integer', ['null' => true, 'length' => 11])
              // ->addColumn('account_id','integer', ['null' => true, 'length' => 11])
              ->addForeignKey('account_category_id','account_categories', 'id')
              ->addForeignKey('account_id','accounts', 'id')
              ->save();
    }
}
