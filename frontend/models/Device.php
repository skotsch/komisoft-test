<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "device".
 *
 * @property int $id
 * @property string $serial_number
 * @property int|null $store_id
 * @property int|null $created_at
 *
 * @property BatchDevice[] $batchDevices
 * @property Batch[] $batches
 * @property Store $store
 */
class Device extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%device}}';
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
            [['store_id', 'created_at'], 'default', 'value' => null],
            [['serial_number'], 'required'],
            [['store_id', 'created_at'], 'integer'],
            [['serial_number'], 'string', 'max' => 255],
            [['serial_number'], 'unique'],
            [['store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::class, 'targetAttribute' => ['store_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'serial_number' => 'Серийный номер',
            'store_id' => 'Склад',
            'created_at' => 'Дата создания',
        ];
    }

    /**
     * Проверяет, можно ли переместить устройство
     * Устройство нельзя переместить если оно уже находится в активной партии  
     */
    public function canBeMoved()
    {
        $activeBatch = Batch::find()
            ->joinWith('batchDevices')
            ->where(['batch_device.device_id' => $this->id])
            ->andWhere(['IN', 'batch_status_id', [Batch::STATUS_PENDING, Batch::STATUS_IN_TRANSIT]])
            ->exists();

        return !$activeBatch;
    }

    /**
     * Получить человеко-читаемое представление
     */
    public function getDisplayName()
    {
        return $this->serial_number . ($this->store ? " ({$this->store->name})" : ' (Не на складе)');
    }

    /**
     * Gets query for [[BatchDevices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBatchDevices()
    {
        return $this->hasMany(BatchDevice::class, ['device_id' => 'id']);
    }

    /**
     * Gets query for [[Batches]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBatches()
    {
        return $this->hasMany(Batch::class, ['id' => 'batch_id'])->viaTable('batch_device', ['device_id' => 'id']);
    }

    /**
     * Gets query for [[Store]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStore()
    {
        return $this->hasOne(Store::class, ['id' => 'store_id']);
    }

}
