<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

final class Database
{
    private static ?PDO $connection = null;

    /**
     * Get the active PDO connection.
     */
    public static function connection(): PDO
    {
        if (self::$connection instanceof PDO) {
            return self::$connection;
        }

        $configFile = BASE_PATH . '/config/database.php';

        if (!is_file($configFile)) {
            throw new RuntimeException(
                'Database configuration file not found: ' . $configFile
            );
        }

        $config = require $configFile;

        if (!is_array($config)) {
            throw new RuntimeException(
                'Database configuration must return an array.'
            );
        }

        $driver = strtolower(
            trim(
                (string) ($config['driver'] ?? '')
            )
        );

        if ($driver !== 'mysql') {
            throw new RuntimeException(
                'Unsupported database driver: ' . $driver
            );
        }

        $host = trim(
            (string) ($config['host'] ?? '')
        );

        $port = (int) (
            $config['port'] ?? 3306
        );

        $database = trim(
            (string) ($config['database'] ?? '')
        );

        $username = trim(
            (string) ($config['username'] ?? '')
        );

        $password = (string) (
            $config['password'] ?? ''
        );

        $charset = trim(
            (string) (
                $config['charset'] ?? 'utf8mb4'
            )
        );

        if ($host === '') {
            throw new RuntimeException(
                'Database host is not configured.'
            );
        }

        if ($port <= 0) {
            throw new RuntimeException(
                'Database port is invalid.'
            );
        }

        if ($database === '') {
            throw new RuntimeException(
                'Database name is not configured.'
            );
        }

        if ($username === '') {
            throw new RuntimeException(
                'Database username is not configured.'
            );
        }

        $dsn = sprintf(
            'mysql:host=%s;port=%d;dbname=%s;charset=%s',
            $host,
            $port,
            $database,
            $charset
        );

        $options = is_array(
            $config['options'] ?? null
        )
            ? $config['options']
            : [
                PDO::ATTR_ERRMODE =>
                    PDO::ERRMODE_EXCEPTION,

                PDO::ATTR_DEFAULT_FETCH_MODE =>
                    PDO::FETCH_ASSOC,

                PDO::ATTR_EMULATE_PREPARES =>
                    false,

                PDO::ATTR_STRINGIFY_FETCHES =>
                    false,
            ];

        try {
            self::$connection = new PDO(
                $dsn,
                $username,
                $password,
                $options
            );
        } catch (PDOException $exception) {
            $debug = false;

            if (function_exists('config')) {
                $debug = (bool) config(
                    'app.debug',
                    false
                );
            }

            if ($debug) {
                throw new RuntimeException(
                    'Database connection failed: '
                    . $exception->getMessage(),
                    (int) $exception->getCode(),
                    $exception
                );
            }

            throw new RuntimeException(
                'Database connection failed.',
                (int) $exception->getCode(),
                $exception
            );
        }

        return self::$connection;
    }

    /**
     * Execute a prepared query.
     */
    public static function query(
        string $sql,
        array $parameters = []
    ): \PDOStatement {
        $statement = self::connection()->prepare($sql);

        $statement->execute($parameters);

        return $statement;
    }

    /**
     * Fetch one row.
     */
    public static function first(
        string $sql,
        array $parameters = []
    ): ?array {
        $statement = self::query(
            $sql,
            $parameters
        );

        $result = $statement->fetch();

        return $result === false
            ? null
            : $result;
    }

    /**
     * Fetch all rows.
     */
    public static function all(
        string $sql,
        array $parameters = []
    ): array {
        $statement = self::query(
            $sql,
            $parameters
        );

        return $statement->fetchAll();
    }

    /**
     * Execute INSERT, UPDATE or DELETE.
     */
    public static function execute(
        string $sql,
        array $parameters = []
    ): int {
        $statement = self::query(
            $sql,
            $parameters
        );

        return $statement->rowCount();
    }

    /**
     * Get the last inserted ID.
     */
    public static function lastInsertId(): int
    {
        return (int) self::connection()->lastInsertId();
    }

    /**
     * Start a transaction.
     */
    public static function beginTransaction(): void
    {
        self::connection()->beginTransaction();
    }

    /**
     * Commit the transaction.
     */
    public static function commit(): void
    {
        self::connection()->commit();
    }

    /**
     * Roll back the transaction.
     */
    public static function rollBack(): void
    {
        self::connection()->rollBack();
    }

    /**
     * Check whether a transaction is active.
     */
    public static function inTransaction(): bool
    {
        return self::connection()->inTransaction();
    }

    /**
     * Run a callback inside a transaction.
     */
    public static function transaction(
        callable $callback
    ): mixed {
        self::beginTransaction();

        try {
            $result = $callback();

            self::commit();

            return $result;
        } catch (\Throwable $exception) {
            if (self::inTransaction()) {
                self::rollBack();
            }

            throw $exception;
        }
    }
}

