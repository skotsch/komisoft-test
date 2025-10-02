<?php

namespace frontend\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Device extends ActiveRecord
{
    // Таблица БД
    public static function tableName()
    {
        return '{{%device}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class, // автозаполнение created_at
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
            [['serial_number'], 'required'], // Серийник обязателен
            [['serial_number'], 'string', 'max' => 255], // Строка макс. длиной 255 символов
            [['serial_number'], 'unique'], // Серийник уникален
            [['store_id'], 'integer'], // id - целое число
            [['store_id'], 'exist', 
            'skipOnError' => true, 
            'targetClass' => Store::class, 
            'targetAttribute' => ['store_id' => 'id']], // проверяет что store_id существует в таблице stores
        ];
    }

    public function getStore()
    {
        return $this->hasOne(Store::class, [
            'id' => 'store_id'
        ]);
    }
}