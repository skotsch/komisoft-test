<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%batch}}`.
 */
class m251008_114035_create_batch_device_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%batch_device}}', [
            'id' => $this->primaryKey(),
            'batch_id' => $this->integer()->notNull(),
            'device_id' => $this->integer()->notNull(),
        ]);

        // Внешние ключи
        $this->addForeignKey(
            'fk-batch_device-batch_id',
            '{{%batch_device}}',
            'batch_id',
            '{{%batch}}',
            'id',
            'CASCADE',
        );
        $this->addForeignKey(
            'fk-batch_device-device_id',
            '{{%batch_device}}',
            'device_id',
            '{{%device}}',
            'id',
            'CASCADE',
        );

        // Индекс чтобы одно устройство не могло быть в одной партии дважды
        $this->createIndex(
            'idx-batch_device-device_id',
            '{{%batch_device}}',
            ['batch_id', 'device_id'],
            true,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-batch_device-batch_id',
            '{{%batch_device}}',
        );
        $this->dropForeignKey(
            'fk-batch_device-device_id',
            '{{%batch_device}}',
        );
        $this->dropTable('{{%batch_device}}');
    }
}
