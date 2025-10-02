<?php
use yii\helpers\Html;

/** @var yii\web\View $this */

$this->title = 'Система управления складами и устройствами';
?>
<div class="site-index">
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container-fluid py-5 text-center">
            <h1 class="display-4">Система управления</h1>
            <p class="fs-5 fw-light">Управление складами и устройствами компании</p>
            <div class="mt-4">
                <?= Html::a('Управление складами', ['/store/index'], ['class' => 'btn btn-primary btn-lg me-3']) ?>
                <?= Html::a('Управление устройствами', ['/device/index'], ['class' => 'btn btn-success btn-lg']) ?>
            </div>
        </div>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h3 class="card-title">📦 Склады</h3>
                        <p class="card-text">
                            Управление складами компании. Просматривайте список складов, добавляйте новые 
                            и редактируйте существующие. Для каждого склада можно просмотреть список устройств.
                        </p>
                        <ul class="list-unstyled">
                            <li>✅ Просмотр всех складов</li>
                            <li>✅ Добавление и редактирование</li>
                            <li>✅ Модальное окно с устройствами</li>
                        </ul>
                        <?= Html::a('Перейти к складам →', ['/store/index'], ['class' => 'btn btn-outline-primary']) ?>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h3 class="card-title">💻 Устройства</h3>
                        <p class="card-text">
                            Управление устройствами компании. Серийные номера, привязка к складам, 
                            фильтрация и поиск. Удобный интерфейс для работы с оборудованием.
                        </p>
                        <ul class="list-unstyled">
                            <li>✅ CRUD операции с устройствами</li>
                            <li>✅ Фильтрация по складам</li>
                            <li>✅ Удобные формы с Select2</li>
                        </ul>
                        <?= Html::a('Перейти к устройствам →', ['/device/index'], ['class' => 'btn btn-outline-success']) ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center">
                        <h4>🚀 Технологии проекта</h4>
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <h5>Yii2 Framework</h5>
                                <p class="text-muted">PHP фреймворк</p>
                            </div>
                            <div class="col-md-3">
                                <h5>Bootstrap 5</h5>
                                <p class="text-muted">UI компоненты</p>
                            </div>
                            <div class="col-md-3">
                                <h5>Kartik Extensions</h5>
                                <p class="text-muted">Расширенные GridView</p>
                            </div>
                            <div class="col-md-3">
                                <h5>MySQL</h5>
                                <p class="text-muted">База данных</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
