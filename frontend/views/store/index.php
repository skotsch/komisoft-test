<?php

use frontend\models\Store;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\bootstrap5\Modal;

/** @var yii\web\View $this */
/** @var frontend\models\StoreSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Склады';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="store-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить склад', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'attribute' => 'name',
                'label' => 'Название склада',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a($model->name, '#', [
                        'title' => 'Просмотреть устройства',
                        'data-toggle' => 'modal',
                        'data-target' => '#devices-modal',
                        'data-store-id' => $model->id,
                        'data-store-name' => $model->name,
                        'style' => 'cursor: pointer; text-decoration: underline;'
                    ]);
                },
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

    <?php
    // Модальное окно для списка устройств
    Modal::begin([
        'title' => 'Устройства на складе',
        'id' => 'devices-modal',
        'size' => 'modal-lg',
    ]);
    echo "<div id='modal-content'>Загрузка...</div>";
    Modal::end();

    // JavaScript для загрузки данных в модалку
    $this->registerJs("
        var devicesModal = new bootstrap.Modal(document.getElementById('devices-modal'));
        
        // Вешаем обработчик на клик по названию склада
        $(document).on('click', '[data-store-id]', function(e) {
            e.preventDefault();
            
            var storeId = $(this).data('store-id');
            var storeName = $(this).data('store-name');
            
            // Обновляем заголовок модалки
            $('#devices-modal .modal-title').text('Устройства на складе: ' + storeName);
            $('#modal-content').html('Загрузка...');
            
            // Загружаем данные
            $.get('" . \yii\helpers\Url::to(['store/devices-list']) . "', {id: storeId}, function (data) {
                $('#modal-content').html(data);
            });
            
            // Показываем модалку
            devicesModal.show();
        });
    ");
    ?>

</div>
