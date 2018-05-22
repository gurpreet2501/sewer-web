<?php

use Phinx\Migration\AbstractMigration;

class AddMenuItemsForOperatorAndManager extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-clas:
s
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
    	$operator = [
        'gate_entry','daily_labour_accounts','cmr_rice_quality_report','bran_quality_report',
        'machinery_parts',
    	];

    	$manager = [
		    'rate_entry',
        'bran_quality_report',
        'purchase_daily_report',
        'profit_loss_report_generator',
        'transactions_report_generator',
        'gate_entry',
    	];

      Models\UserAccess::truncate();

      foreach ($operator as $key => $feature) {
        Models\UserAccess::create([
          'role' => 'operator',
          'feature' => $feature
        ]);
      }

      foreach ($manager as $key => $val) {
        Models\UserAccess::create([
          'role' => 'manager',
          'feature' => $val
        ]);
      }
    

    }
}
