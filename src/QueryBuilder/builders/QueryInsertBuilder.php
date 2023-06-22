<?php

declare(strict_types=1);

namespace src\QueryBuilder\Builders;

use src\db\db;
use src\db\DbConfigDto;
use src\QueryBuilder\SqlCommands\ColumnsCommand;
use src\QueryBuilder\SqlCommands\SetTableCommand;
use src\QueryBuilder\SqlCommands\SqlStatements;
use src\QueryBuilder\SqlCommands\ValuesCommand;

class QueryInsertBuilder extends BaseCommandsQueryBuilder
{
    private db $db;

    public function __construct(DbConfigDto $dbConfigDto)
    {
        $this->db = db::getInstance($dbConfigDto);
    }

    public function into(string $into): self
    {
        $this->addCommand(new SetTableCommand(SqlStatements::INTO, $into));
        return $this;
    }

    public function columns(array|string $columns): self
    {
        $this->addCommand(new ColumnsCommand($columns));
        return $this;
    }

    public function values(array|string $values): self
    {
        $this->addCommand(new ValuesCommand($values));
        return $this;
    }

    public function execute(): bool
    {
        $request = 'INSERT ' . $this->getSqlRequest();
        var_dump($request);
        return $this->db->execute($request);
    }
}
