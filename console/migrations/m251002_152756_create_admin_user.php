<?php

use yii\db\Migration;

class m251002_152756_create_admin_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $security = new \yii\base\Security();
        
        $this->insert('{{%user}}', [
            'username' => 'admin',
            'email' => 'admin@komisoft.test',
            'password_hash' => $security->generatePasswordHash('admin123'),
            'auth_key' => $security->generateRandomString(),
            'status' => \common\models\User::STATUS_ACTIVE, // 10
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        echo "Пользователь admin создан\n";
        echo "Логин: admin\n";
        echo "Пароль: admin123\n";
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('{{%user}}', ['username' => 'admin']);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m251002_152756_create_admin_user cannot be reverted.\n";

        return false;
    }
    */
}
