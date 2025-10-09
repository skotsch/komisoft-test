<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "store".
 *
 * @property int $id
 * @property string $name
 * @property int|null $created_at
 *
 * @property Batch[] $batches
 * @property Batch[] $batches0
 * @property Device[] $devices
 */
class Store extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%store}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => yii\behaviors\TimestampBehavior::class, // автозаполнение created_at
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
                    // Убрал EVENT_BEFORE_UPDATE => ['updated_at']
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['created_at'], 'default', 'value' => null],
            [['name'], 'required'],
            [['created_at'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название склада',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * Gets query for [[Batches]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBatchesFrom()
    {
        return $this->hasMany(Batch::class, ['from_store_id' => 'id']);
    }

    /**
     * Gets query for [[Batches0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBatchesTo()
    {
        return $this->hasMany(Batch::class, ['to_store_id' => 'id']);
    }

    /**
     * Gets query for [[Devices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDevices()
    {
        return $this->hasMany(Device::class, ['store_id' => 'id']);
    }

}
