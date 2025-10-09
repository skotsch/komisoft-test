<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%batch_status}}`.
 */
class m251008_111236_create_batch_status_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%batch_status}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
        ]);

        $this->batchInsert('{{%batch_status}}', ['name'], [
            ['Ожидает отправки'],
            ['В пути'],
            ['Принята'],
            ['Отклонена'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%batch_status}}');
    }
}
