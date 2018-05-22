<?php

use Phinx\Migration\AbstractMigration;

class UpdateAccountIdInLabourPartyRelationTable extends AbstractMigration
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
        $this->table('labour_party_job_types')
              ->dropForeignKey('account_id')
              ->removeColumn('account_id')
              ->save();

        $this->table('labour_party_job_types')
            ->addColumn('account_id','integer', ['null' => true, 'length' => 11, 'after' => 'labour_job_type_id'])
            ->addForeignKey('account_id','accounts', 'id')
            ->save();
    }
}
