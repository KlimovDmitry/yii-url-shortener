<?php

use yii\db\Migration;

/**
 * Handles the creation of table `short_url_statistics`.
 */
class m180122_150522_create_short_url_statistics_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('short_url_statistics', [
            'id' => $this->primaryKey(),
            'url_short' => $this->string(8)->notNull(),
            'created_at' => $this->dateTime(),
            'geo_data' => $this->text()->notNull(),
            'user_agent' => $this->string(255)->notNull(),
        ], 'ENGINE InnoDB');
        
        $this->addForeignKey('fk_short_url_code', 'short_url_statistics', 'url_short', 'short_url', 'url_short', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey(
            'fk_short_url_code',
            'short_url_statistics'
        );
        
        $this->dropTable('short_url_statistics');
    }
}
