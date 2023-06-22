<?php

declare(strict_types=1);

namespace src\QueryBuilder\CommandsBuilders;

use src\db\db;
use src\db\DbConfigDto;
use src\QueryBuilder\SqlCommands\SetCommand;
use src\QueryBuilder\SqlCommands\SetTableCommand;
use src\QueryBuilder\SqlCommands\SqlStatements;
use src\QueryBuilder\SqlCommands\WhereCommand;

class CommandsQueryUpdateBuilder extends BaseCommandsQueryBuilder
{
    private db $db;

    public function __construct(DbConfigDto $dbConfigDto)
    {
        $this->db = db::getInstance($dbConfigDto);
    }

    public function update(string $table): self
    {
        $this->addCommand(new SetTableCommand(SqlStatements::UPDATE, $table));
        return $this;
    }

    public function set(array $columnValues): self
    {
        $this->addCommand(new SetCommand($columnValues));
        return $this;
    }

    public function where(array $where): self
    {
        $this->addCommand(new WhereCommand($where));
        return $this;
    }

    public function execute(): bool
    {
        $request = $this->getSqlRequest();
        return $this->db->execute($request);
    }
}
