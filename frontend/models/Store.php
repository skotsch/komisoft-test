<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Store extends ActiveRecord
{
    // Таблица БД
    public static function tableName()
    {
        return '{{%store}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    // Убрал EVENT_BEFORE_UPDATE => ['updated_at'] 
                ],
            ],
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

    public function getDevices()
    {
        return $this->hasMany(Device::class, [
            'store_id' => 'id'
        ]);
    }
}