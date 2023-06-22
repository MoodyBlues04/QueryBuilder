<?php

declare(strict_types=1);

namespace src\QueryBuilder\CommandsBuilders;

use src\db\db;
use src\db\DbConfigDto;
use src\QueryBuilder\SqlCommands\SetTableCommand;
use src\QueryBuilder\SqlCommands\SqlStatements;
use src\QueryBuilder\SqlCommands\WhereCommand;

class CommandsQueryDeleteBuilder extends BaseCommandsQueryBuilder
{
    private db $db;

    public function __construct(DbConfigDto $dbConfigDto)
    {
        $this->db = db::getInstance($dbConfigDto);
    }

    public function from(string $from): self
    {
        $this->addCommand(new SetTableCommand(SqlStatements::FROM, $from));
        return $this;
    }

    public function where(array $where): self
    {
        $this->addCommand(new WhereCommand($where));
        return $this;
    }

    public function execute(): bool
    {
        $request = 'DELETE ' . $this->getSqlRequest();
        var_dump($request);
        return $this->db->execute($request);
    }
}
