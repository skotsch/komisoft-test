<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var frontend\models\Batch $model */

$this->title = 'Create Batch';
$this->params['breadcrumbs'][] = ['label' => 'Batches', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="batch-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
