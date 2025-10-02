<?php

use frontend\models\Device;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var frontend\models\DeviceSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Устройства';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить устройство', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'serial_number',
                'label' => 'Серийный номер',
            ],
            [
                'attribute' => 'store_id',
                'label' => 'Название склада',
                'value' => 'store.name', // название склада вместо ID
                'filter' => Select2::widget([ // Select2 для фильтра
                    'model' => $searchModel,
                    'attribute' => 'store_id',
                    'data' => ArrayHelper::map(\frontend\models\Store::find()->all(), 'id', 'name'),
                    'options' => ['placeholder' => 'Select a store...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],
            [
                'attribute' => 'created_at',
                'label' => 'Дата создания',
                'format' => 'datetime',
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'header' => 'Действия',
            ],
        ],
    ]); ?>

</div>
