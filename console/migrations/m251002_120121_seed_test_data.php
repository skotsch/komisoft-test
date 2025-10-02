<?php

use yii\db\Migration;

class m251002_120121_seed_test_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Склады
        $this->batchInsert('{{%store}}', ['name', 'created_at'], [
            ['Основной склад', time()],
            ['Запасной склад', time()],
            ['Центральный склад', time()],
            ['Склад комплектующих', time()],
            ['Филиал №1', time()],
        ]);

        // Устройства
        $this->batchInsert('{{%device}}', ['serial_number', 'store_id', 'created_at'], [
            ['SN-2024-001', 1, time()],
            ['SN-2024-002', 1, time()],
            ['SN-2024-003', 1, time()],
            ['SN-2024-004', 2, time()],
            ['SN-2024-005', 2, time()],
            ['SN-2024-006', 3, time()],
            ['SN-2024-007', 3, time()],
            ['SN-2024-008', 4, time()],
            ['SN-2024-009', 5, time()],
            ['SN-2024-010', null, time()], // без склада
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m251002_120121_seed_test_data cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251002_120121_seed_test_data cannot be reverted.\n";

        return false;
    }
    */
}
