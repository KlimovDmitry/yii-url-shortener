<?php

use yii\db\Migration;

/**
 * Handles the creation of table `short_url`.
 */
class m180122_150511_create_short_url_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('short_url', [
            'url_short' => $this->string(8)->notNull()->unique(),
            'url_original' => $this->text()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->dateTime(),
            'expire_at' => $this->dateTime(),
        ], 'ENGINE InnoDB');
        
        $this->addForeignKey('fk_short_url_user_id', 'short_url', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk_short_url_user_id',
            'short_url'
        );
        
        $this->dropTable('short_url');
    }
}
