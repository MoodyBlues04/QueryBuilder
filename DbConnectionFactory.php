<?php

declare(strict_types=1);

class DbConnectionFactory
{
    private const DB_TYPES = [];

    public static function create(DbConfigDto $configDto)
    {
        self::checkDbType($configDto->dbType);
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
