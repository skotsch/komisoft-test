<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%device}}`.
 */
class m251001_191721_create_device_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%device}}', [
            'id' => $this->primaryKey(),
            'serial_number' => $this->string()->notNull()->unique(),
            'store_id' => $this->integer()->null(),
            'created_at' => $this->integer(),
        ]);

        // Индекс для store_id
        $this->createIndex(
            'idx-decice-store_id',
            '{{%device}}',
            'store_id'
        );

        // Создаём внешний ключ
        $this->addForeignKey(
            'fk-device-store_id',
            '{{%device}}',
            'store_id',
            '{{%store}}',
            'id',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-device-store_id',
            '{{%device}}'
        );

        $this->dropIndex(
            'idx-decice-store_id',
            '{{%device}}'
        );

        $this->dropTable('{{%device}}');
    }
}
