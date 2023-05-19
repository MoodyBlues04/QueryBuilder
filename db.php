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

    private $dbConnection;

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

    public function changeDbConfig(DbConfigDto $configDto): void
    {
        $this->dbConnection = DbConnectionFactory::create($configDto);
    }

    public function query(string $query): mixed
    {
        $result = $this->dbConnection->query($query);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;
        }

        return null;
    }
}
