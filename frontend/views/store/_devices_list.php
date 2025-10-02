<?php
use yii\helpers\Html;
?>
<div class="devices-list">
    <?php if (empty($devices)): ?>
        <p>На этом складе нет устройств</p>
    <?php else: ?>
        <ul class="list-group">
            <?php foreach ($devices as $device): ?>
                <li class="list-group-item">
                    <?= Html::a($device->serial_number, 
                    ['device/index', 'DeviceSearch[serial_number]' => $device->serial_number], 
                    [
                        'target' => '_blank',
                        'class' => 'text-primary',
                        'title' => 'Открыть список устройств с фильтром по этому серийному номеру'
                    ]) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>