<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%batch}}`.
 */
class m251008_111352_create_batch_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%batch}}', [
            'id' => $this->primaryKey(),
            'batch_number' => $this->string()->notNull()->unique(),
            'from_store_id' => $this->integer()->notNull(),
            'to_store_id' => $this->integer()->notNull(),
            'batch_status_id' => $this->integer()->notNull()->defaultValue(1), // по умолчанию "Ожидает отправки"
            'created_at' => $this->integer(),
        ]);

        // Внешние ключи
        $this->addForeignKey(
            'fk-batch-from_store_id',
            '{{%batch}}',
            'from_store_id',
            '{{%store}}',
            'id',
            'CASCADE',
        );
        $this->addForeignKey(
            'fk-batch-to_store_id',
            '{{%batch}}',
            'to_store_id',
            '{{%store}}',
            'id',
            'CASCADE',
        );
        $this->addForeignKey(
            'fk-batch-batch_status',
            '{{%batch}}',
            'batch_status_id',
            '{{%batch_status}}',
            'id',
            'CASCADE',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-batch-from_store_id',
            '{{%batch}}',
        );
        $this->dropForeignKey(
            'fk-batch-to_store_id',
            '{{%batch}}',
        );
        $this->dropForeignKey(
            'fk-batch-batch_status',
            '{{%batch}}',
        );
        $this->dropTable('{{%batch}}');
    }
}
