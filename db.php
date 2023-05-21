<?php

declare(strict_types=1);

class db
{
    private static ?self $instance = null;

    public static function getInstance(DbConfigDto $configDto): self
    {
        if (!self::$instance instanceof self) {
            self::$instance = new self($configDto);
        }
        return self::$instance;
    }

    private PDO $dbConnection;

    /**
     * @throws PDOException
     */
    private function __construct(DbConfigDto $configDto)
    {
        $this->changeDbConfig($configDto);
    }

    /**
     * @throws \Exception
     */
    public function __clone(): void
    {
        throw new \Exception('Clone is not allowed.');
    }

    /**
     * @throws \Exception
     */
    public function __wakeup(): void
    {
        throw new \Exception('Deserializing is not allowed.');
    }

    /**
     * @throws PDOException
     */
    public function changeDbConfig(DbConfigDto $configDto): void
    {
        $this->dbConnection = DbConnectionFactory::create($configDto);
    }

    public function query(string $query): ?array
    {
        $result = $this->dbConnection->query($query);
        if ($result->rowCount() > 0) {
            $row = $result->fetchAll(PDO::FETCH_DEFAULT);
            return $row;
        }

        return null;
    }
}
