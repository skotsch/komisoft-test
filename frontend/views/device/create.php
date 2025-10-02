<?php

use yii\helpers\Html;
use kartik\select2\Select2;

/** @var yii\web\View $this */
/** @var frontend\models\Device $model */

$this->title = 'Добавить устройство';
$this->params['breadcrumbs'][] = ['label' => 'Devices', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="device-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
