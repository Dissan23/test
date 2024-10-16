<?php

namespace App\Command;

use Core\App;
use Exception;
use PDO;
use PDOException;

class Commander
{
    /**
     * Запуск всех миграций, которые ещё не были выполнены.
     *
     * @param string $name Название конкретной миграции для выполнения (если нужно)
     */
    public function runMigration(string $name = ''): void
    {
        $connection = App::getApp()->Db->getConnection();
        $executedMigrations = $this->getExecutedMigrations();  // Получение выполненных миграций
        $migrationFiles = $this->scanMigrationFiles();         // Получение всех файлов миграций

        foreach ($migrationFiles as $migration) {
            // Пропустить миграцию, если она уже была выполнена
            if (in_array($migration, array_column($executedMigrations, 'name'))) {
                continue;
            }

            // Загружаем SQL-команду из файла
            $sqlCommands = file_get_contents('./Migrations/' . $migration);

            $connection->beginTransaction();  // Начало транзакции

            try {
                // Выполнение SQL команды из миграции
                $connection->exec($sqlCommands);

                // Запись выполненной миграции в таблицу migrations
                $connection->exec("INSERT INTO migrations (name) VALUES (:migration)", [
                    ':migration' => $migration
                ]);

                // Коммит транзакции
                $connection->commit();
            } catch (Exception $e) {
                // В случае ошибки откатываем транзакцию
                $connection->rollBack();
                echo "Ошибка выполнения миграции: {$migration}. Ошибка: {$e->getMessage()}";
            }
        }
    }

    /**
     * Получение списка всех файлов миграций в директории ./Migrations.
     *
     * @return array Список файлов миграций.
     */
    private function scanMigrationFiles(): array
    {
        return array_diff(scandir('./Migrations'), ['.', '..']);
    }

    /**
     * Получение списка выполненных миграций из базы данных.
     *
     * @return array Список выполненных миграций.
     */
    private function getExecutedMigrations(): array
    {
        $connection = App::getApp()->Db->getConnection();

        try {
            // Проверка, существует ли таблица migrations
            $result = $connection->query("SELECT 1 FROM migrations LIMIT 1");
        } catch (PDOException $e) {
            // Если таблица не существует (ошибка "42S02"), создаем её
            if ($e->getCode() == '42S02') {
                $this->createMigrationsTable($connection);
            }
        }

        // Получение списка выполненных миграций
        $stmt = $connection->query("SELECT name FROM migrations", PDO::FETCH_ASSOC);
        return $stmt->fetchAll();
    }

    /**
     * Создание таблицы migrations, если она не существует.
     *
     * @param PDO $connection Соединение с базой данных.
     */
    private function createMigrationsTable(PDO $connection): void
    {
        $createTableSQL = "
            CREATE TABLE IF NOT EXISTS migrations (
                id INT AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL
            )
        ";
        $connection->exec($createTableSQL);
    }
}