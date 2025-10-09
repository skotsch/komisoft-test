<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "batch".
 *
 * @property int $id
 * @property string $batch_number
 * @property int $from_store_id
 * @property int $to_store_id
 * @property int $batch_status_id
 * @property int|null $created_at
 *
 * @property BatchDevice[] $batchDevices
 * @property BatchStatus $batchStatus
 * @property Device[] $devices
 * @property Store $fromStore
 * @property Store $toStore
 */
class Batch extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 1;      // Ожидает отправки
    const STATUS_IN_TRANSIT = 2;   // В пути
    const STATUS_ACCEPTED = 3;     // Принята
    const STATUS_REJECTED = 4;     // Отклонена

    // Виртуальное поле для хранения выбранных устройств в форме
    public $device_ids = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%batch}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => \yii\behaviors\TimestampBehavior::class,
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at'],
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
            [['batch_status_id'], 'default', 'value' => self::STATUS_PENDING],
            [['batch_number', 'from_store_id', 'to_store_id'], 'required'],
            [['from_store_id', 'to_store_id', 'batch_status_id', 'created_at'], 'integer'],
            [['batch_number'], 'string', 'max' => 255],
            [['batch_number'], 'unique'],

            // Валидация для виртуального поля
            [['device_ids'], 'required', 'message' => 'Необходимо выбрать хотя бы одно устройство'],
            [['device_ids'], 'each', 'rule' => ['integer']],
            
            // Запретить отправку на тот же склад
            ['to_store_id', 'compare', 'compareAttribute' => 'from_store_id', 'operator' => '!='],

            [['batch_status_id'], 'exist', 'skipOnError' => true, 'targetClass' => BatchStatus::class, 'targetAttribute' => ['batch_status_id' => 'id']],
            [['from_store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::class, 'targetAttribute' => ['from_store_id' => 'id']],
            [['to_store_id'], 'exist', 'skipOnError' => true, 'targetClass' => Store::class, 'targetAttribute' => ['to_store_id' => 'id']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'batch_number' => 'Номер партии',
            'from_store_id' => 'Склад отправления',
            'to_store_id' => 'Склад получения',
            'batch_status_id' => 'Статус',
            'created_at' => 'Дата создания',
            'device_ids' => 'Устройства для перемещения',
        ];
    }

    /**
     * Генерация уникального номера партии формата:
     * BATCH-20241008-0001
     */
    public function generateBatchNumber()
    {
        $date = date('Ymd');
        $lastBatch = self::find()
            ->where(['LIKE', 'batch_number', 'BATCH' . $date . '-'])
            ->orderBy(['id' => SORT_DESC])
            ->one();

        $sequence = 1;
        if ($lastBatch) {
            preg_match('/-(\d+)$/', $lastBatch->batch_number, $matches);
            if (isset($matches[1])) {
                $sequence = (int)$matches[1] + 1;
            }
        }

        return 'BATCH-' . $date . '-' . str_pad($sequence, 4, '0', STR_PAD_LEFT); 
    }

    /**
     * Проверка можно ли принять партию
     */
    public function canBeAccepted()
    {
        return $this->batch_status_id == self::STATUS_IN_TRANSIT;
    }

    /**
     * Проверка можно ли отклонить партию
     */
    public function canBeRejected()
    {
        return in_array($this->batch_status_id, [self::STATUS_IN_TRANSIT, self::STATUS_PENDING]);
    }

    /**
     * Принять партию - переместить устройство и изменить статус
     */
    public function accept()
    {
        $transaction = Yii::$app->db->beginTransaction();
        try {
            // Перемещение всех устройств на склад получения
            foreach ($this->devices as $device) {
                $device->store_id = $this->to_store_id;
                if (!$device->save()) {
                    throw new \Exception("Ошибка при перемещени устройства" . $device->serial_number);                    
                }
            }

            // Изменение статуса партии на "Принята"
            $this->batch_status_id = self::STATUS_ACCEPTED;
            if (!$this->save()) {
                throw new \Exception("Ошибка при обновлении статуса партии");
                
            }

            $transaction->commit();
            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            throw $e;
        }
    }

    /**
     * Отклонить партию
     */
    public function reject()
    {
        $this->batch_status_id = self::STATUS_REJECTED;
        return $this->save();
    }

    /**
     * Gets query for [[BatchDevices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBatchDevices()
    {
        return $this->hasMany(BatchDevice::class, ['batch_id' => 'id']);
    }

    /**
     * Gets query for [[BatchStatus]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBatchStatus()
    {
        return $this->hasOne(BatchStatus::class, ['id' => 'batch_status_id']);
    }

    /**
     * Gets query for [[Devices]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDevices()
    {
        return $this->hasMany(Device::class, ['id' => 'device_id'])->viaTable('batch_device', ['batch_id' => 'id']);
    }

    /**
     * Gets query for [[FromStore]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFromStore()
    {
        return $this->hasOne(Store::class, ['id' => 'from_store_id']);
    }

    /**
     * Gets query for [[ToStore]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getToStore()
    {
        return $this->hasOne(Store::class, ['id' => 'to_store_id']);
    }

}
