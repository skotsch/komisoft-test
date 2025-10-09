<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "batch_device".
 *
 * @property int $id
 * @property int $batch_id
 * @property int $device_id
 *
 * @property Batch $batch
 * @property Device $device
 */
class BatchDevice extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%batch_device}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['batch_id', 'device_id'], 'required'],
            [['batch_id', 'device_id'], 'integer'],
            [['batch_id', 'device_id'], 'unique', 'targetAttribute' => ['batch_id', 'device_id']],
            [['batch_id'], 'exist', 'skipOnError' => true, 'targetClass' => Batch::class, 'targetAttribute' => ['batch_id' => 'id']],
            [['device_id'], 'exist', 'skipOnError' => true, 'targetClass' => Device::class, 'targetAttribute' => ['device_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'batch_id' => 'Batch ID',
            'device_id' => 'Device ID',
        ];
    }

    /**
     * Gets query for [[Batch]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBatch()
    {
        return $this->hasOne(Batch::class, ['id' => 'batch_id']);
    }

    /**
     * Gets query for [[Device]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDevice()
    {
        return $this->hasOne(Device::class, ['id' => 'device_id']);
    }

}
