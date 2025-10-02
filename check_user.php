<?php
require_once __DIR__ . '/vendor/autoload.php';
$config = require __DIR__ . '/frontend/config/main.php';

new yii\web\Application($config);

$user = \common\models\User::findOne(['username' => 'admin']);
if ($user) {
    echo "✅ Пользователь найден:\n";
    echo "Username: " . $user->username . "\n";
    echo "Status: " . $user->status . "\n";
    
    $isValid = Yii::$app->security->validatePassword('admin123', $user->password_hash);
    echo "Пароль верный: " . ($isValid ? '✅' : '❌') . "\n";
    
    if (!$isValid) {
        echo "Попробуй пароль: password\n";
        $isValid = Yii::$app->security->validatePassword('password', $user->password_hash);
        echo "Пароль 'password' верный: " . ($isValid ? '✅' : '❌') . "\n";
    }
} else {
    echo "❌ Пользователь не найден\n";
}