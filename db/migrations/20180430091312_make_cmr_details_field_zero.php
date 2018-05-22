<?php
use Illuminate\Database\Capsule\Manager as DB;
use Phinx\Migration\AbstractMigration;

class MakeCmrDetailsFieldZero extends AbstractMigration
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


        
          DB::table('canceled_ge_cmr_details')
            ->where(DB::raw('CAST(tp_date AS char)'),'0000-00-00')
            ->update([
            'tp_date' => '1970-01-01'
          ]);      
          
          DB::table('canceled_ge_cmr_details')
            ->where(DB::raw('CAST(ac_note_date AS char)'), '0000-00-00')
            ->update([
            'ac_note_date' => '1970-01-01'
          ]); 
           
         
          $table = $this->table('canceled_ge_cmr_details');
          
          $table->changeColumn('tp_date', 'date', ['null' => true])
                ->changeColumn('ac_note_date', 'date', ['null' => true])
                ->update();

          DB::table('canceled_ge_cmr_details')
            ->where('tp_date', '1970-01-01')
            ->update([
            'tp_date' => NULL
          ]);      

          DB::table('canceled_ge_cmr_details')
            ->where('ac_note_date', '1970-01-01')
            ->update([
            'ac_note_date' => NULL
          ]);      

          $table = $this->table('canceled_ge_cmr_details');
          $table->changeColumn('cmr_agency_id', 'integer', ['default' =>0])->update();
    }
}
