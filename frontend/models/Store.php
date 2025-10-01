<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Store extends ActiveRecord
{
    // Таблица БД
    public function tableName()
    {
        return '{{%store}}';
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class, // автозаполнение created_at
        ];
    }

    public function rules()
    {
        return [
            [['name'], 'required'], // Название обязательно
            [['name'], 'string', 'max' => 255], // Строка макс. длиной 255 символов
            [['name'], 'unique'], // Название уникально
        ];
    }

    public function getDevice()
    {
        return $this->hasMany(Device::class, [
            'store_id' => 'id'
        ]);
    }
}