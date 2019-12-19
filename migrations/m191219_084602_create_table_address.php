<?php

use yii\db\Migration;

/**
 * Class m191219_084602_create_table_address
 */
class m191219_084602_create_table_address extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%address}}', [
            'id' => $this->primaryKey(),
            'post_index' => $this->string(5)->notNull(),
            'country' => $this->string(2)->notNull(),
            'city' => $this->string(255)->notNull(),
            'street' => $this->string(255)->notNull(),
            'house_number' => $this->string(5)->notNull(),
            'office_number' => $this->integer(11),
            'customer_id' => $this->integer(11)->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull()
        ]);

        $this->addForeignKey('fk--address-customer', '{{%address}}', 'customer_id', '{{%customer}}', 'id', 'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%address}}');
    }
}
