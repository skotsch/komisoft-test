<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use frontend\models\Store;

/** @var yii\web\View $this */
/** @var frontend\models\Device $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="device-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'serial_number')->textInput([
        'maxlength' => true,
        'placeholder' => 'Введите серийный номер'
        ])->label('Серийный номер') ?>

    <?= $form->field($model, 'store_id')->widget(Select2::class, [
        'data' => ArrayHelper::map(Store::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => 'Выберите склад...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ])->label('Склад') ?>


    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
