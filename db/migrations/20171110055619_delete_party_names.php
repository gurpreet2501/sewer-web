<?php

use Phinx\Migration\AbstractMigration;
class DeletePartyNames extends AbstractMigration
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
        $this->execute('SET FOREIGN_KEY_CHECKS=0');
        $row = $this->fetchAll('SELECT * FROM accounts_group where name in ("SundryCreditors","SundryDebtors")');
        foreach ($row as $key => $v) {
            $this->execute("DELETE FROM accounts where accounts_group_id={$v['id']}");
        }
        $this->execute('SET FOREIGN_KEY_CHECKS=1');

    }
}
