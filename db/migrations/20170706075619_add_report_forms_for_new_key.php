<?php

use Phinx\Migration\AbstractMigration;

class AddReportFormsForNewKey extends AbstractMigration
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

        Models\UserAccess::where('role','operator')->whereIn('feature',['transactions_report_generator','profit_loss_report_generator'])->delete();

        Models\UserAccess::where('role','manager')->whereIn('feature',['transactions_report_generator','profit_loss_report_generator'])->delete();

        $arr = [
            0 => [
                'role' => 'operator',
                 'feature' => 'profit_loss_report'
            ],
            1 => [
                'role' => 'operator',
                 'feature' => 'transactions_report'
            ],
            2 => [
                'role' => 'manager',
                 'feature' => 'transactions_report'
            ],
            3 => [
                'role' => 'manager',
                 'feature' => 'profit_loss_report'
            ],
        ];

        foreach ($arr as $key => $v) {
            Models\UserAccess::create($v);
        }
        
    }
}
