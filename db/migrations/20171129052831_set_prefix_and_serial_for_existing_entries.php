<?php
use Phinx\Migration\AbstractMigration;

class SetPrefixAndSerialForExistingEntries extends AbstractMigration
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

      $inEntries = Models\GateEntry::where('entry_type','IN')->get();
      
      $serial = 1;
      foreach ($inEntries as $key => $entry) {
        $entry->prefix = 'MI';
        $entry->serial = $serial;
        $entry->save();
        $serial = $serial + 1;
      }

      $outEntries = Models\GateEntry::where('entry_type','OUT')->get();
      
      $serial = 1;
      foreach ($outEntries as $key => $entry) {
        $entry->prefix = 'MO';
        $entry->serial = $serial;
        $entry->save();
        $serial = $serial + 1;
      }


    }
}
