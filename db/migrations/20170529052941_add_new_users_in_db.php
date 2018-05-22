<?php

use Phinx\Migration\AbstractMigration;

class AddNewUsersInDb extends AbstractMigration
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
        
        $table = $this->table('users');
        if(!$table->hasColumn('username'))
            $table->addColumn('updated_at','datetime')
                  ->update();

        $users = [
            [
                'username' => 'admin',
                'password' => '$2a$08$QhH.mPOx1koPzagnnwFjs.zaSJvUTRTM7bXhB2kURaapPMlzNB8V2',
                'role' => 'admin',
                'activated' => 1,
                'email' => 'admin@admin.com',
            ],
            [
                'username' => 'operator',
                'password' => '$2a$08$QhH.mPOx1koPzagnnwFjs.zaSJvUTRTM7bXhB2kURaapPMlzNB8V2',
                'role' => 'operator',
                'activated' => 1,
                'email' => 'operator@operator.com',
            ],
            [
                'username' => 'manager',
                'password' => '$2a$08$QhH.mPOx1koPzagnnwFjs.zaSJvUTRTM7bXhB2kURaapPMlzNB8V2',
                'role' => 'manager',
                'activated' => 1,
                'email' => 'manager@manager.com',
            ],

        ];
        Models\Users::truncate();
        foreach ($users as $key => $user) {
            Models\Users::create($user);
        }
    }
}
