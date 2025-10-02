<?php

use yii\db\Migration;

class m251002_090611_fix_collation extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Меняем кодировку таблиц на utf8mb4
        $this->execute('ALTER TABLE {{%store}} CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        $this->execute('ALTER TABLE {{%device}} CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        $this->execute('ALTER TABLE {{%migration}} CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->execute('ALTER TABLE {{%store}} CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci');
        $this->execute('ALTER TABLE {{%device}} CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci');
        $this->execute('ALTER TABLE {{%migration}} CONVERT TO CHARACTER SET latin1 COLLATE latin1_swedish_ci');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251002_090611_fix_collation cannot be reverted.\n";

        return false;
    }
    */
}
