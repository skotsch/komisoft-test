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
                    <?= Html::a($device->serial_number, ['device/view', 'id' => $device->id], [
                        'target' => '_blank',
                        'class' => 'device-link'
                    ]) ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</div>