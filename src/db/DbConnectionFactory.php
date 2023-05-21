<?php

declare(strict_types=1);

namespace src\db;

class DbConnectionFactory
{
    const DB_TYPE_MYSQL = 'mysql';

    /** @var string[] */
    private const DB_TYPES = [
        self::DB_TYPE_MYSQL
    ];

    /**
     * @throws \PDOException
     */
    public static function create(DbConfigDto $configDto): \PDO
    {
        self::checkDbType($configDto->dbType);
        return new \PDO(
            "{$configDto->dbType}:host={$configDto->dbHost};dbname={$configDto->dbName}",
            $configDto->user,
            $configDto->password
        );
    }

    /**
     * @param string $dbType
     * 
     * @throws \InvalidArgumentException
     */
    private static function checkDbType(string $dbType): void
    {
        if (!in_array($dbType, self::DB_TYPES)) {
            throw new \InvalidArgumentException("Invalid db type: {$dbType}");
        }
    }
}
