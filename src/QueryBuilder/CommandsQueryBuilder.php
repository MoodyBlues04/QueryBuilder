<?php

declare(strict_types=1);

namespace src\QueryBuilder;

use src\db\DbConfigDto;
use src\QueryBuilder\CommandsBuilders\CommandsQueryDeleteBuilder;
use src\QueryBuilder\CommandsBuilders\CommandsQueryInsertBuilder;
use src\QueryBuilder\CommandsBuilders\CommandsQuerySelectBuilder;
use src\QueryBuilder\CommandsBuilders\CommandsQueryUpdateBuilder;

class CommandsQueryBuilder
{
    private DbConfigDto $dbConfigDto;

    public function __construct(DbConfigDto $dbConfigDto)
    {
        $this->dbConfigDto = $dbConfigDto;
    }

    public function select(string|array $select): CommandsQuerySelectBuilder
    {
        $selectQueryBuilder = new CommandsQuerySelectBuilder($this->dbConfigDto);
        return $selectQueryBuilder->select($select);
    }

    public function insert(): CommandsQueryInsertBuilder
    {
        $insertQueryBuilder = new CommandsQueryInsertBuilder($this->dbConfigDto);
        return $insertQueryBuilder;
    }

    public function update(string $table): CommandsQueryUpdateBuilder
    {
        $updateQueryBuilder = new CommandsQueryUpdateBuilder($this->dbConfigDto);
        return $updateQueryBuilder->update($table);
    }

    public function delete(): CommandsQueryDeleteBuilder
    {
        $deleteQueryBuilder = new CommandsQueryDeleteBuilder($this->dbConfigDto);
        return $deleteQueryBuilder;
    }
}