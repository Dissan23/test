<?php

require_once '/home/dissan/develop/Project/Volume/autoloader.php';  // Указываем путь к автозагрузчику

use App\Command\Commander;

// Создаем экземпляр класса Commander
$commander = new Commander();

// Запускаем миграции
$commander->runMigration();

echo "Миграции завершены!\n";

