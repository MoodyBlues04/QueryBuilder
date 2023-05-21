<?php

declare(strict_types=1);

class DbConfigDto
{
    public string $dbType;
    public string $dbHost;
    public string $dbName;
    public ?string $user = null;
    public ?string $password = null;
}
