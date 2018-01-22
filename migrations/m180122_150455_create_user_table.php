<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m180122_150455_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], 'ENGINE InnoDB');
        
        $this->addColumn('user', 'gender', "ENUM('male','female') DEFAULT NULL");
        $this->addColumn('user', 'birthday', "DATE NULL DEFAULT NULL");
        
        $this->insert('user', [
            'id' => 1,
            'username' => 'admin',
            'auth_key' => '',
            'password_hash' => '$2y$13$iH.WCPKJtdEW0SaJH2ehF.TGcPpm/vWdi6KGEosBFc89fi1SrOJV6',
            'password_reset_token' => null,
            'email' => 'admin@current.site',
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
            'gender' => 'male',
            'birthday' => '1985-03-22',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
