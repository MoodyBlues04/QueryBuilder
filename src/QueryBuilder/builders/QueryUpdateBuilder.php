<?php

declare(strict_types=1);

namespace src\QueryBuilder\Builders;

use src\db\db;
use src\db\DbConfigDto;
use src\QueryBuilder\SqlCommands\Condition\Operators;
use src\QueryBuilder\SqlCommands\SetCommand;
use src\QueryBuilder\SqlCommands\SetTableCommand;
use src\QueryBuilder\SqlCommands\SqlStatements;
use src\QueryBuilder\SqlCommands\WhereCommand;

class QueryUpdateBuilder extends BaseCommandsQueryBuilder
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

    public function andWhere(array $andWhere): self
    {
        $this->checkIsLastStatement(SqlStatements::WHERE);

        /** @var WhereCommand */
        $command = $this->getLastCommand();
        $command->addCondition(Operators::AND, $andWhere);
        return $this;
    }

    public function orWhere(array $orWhere): self
    {
        $this->checkIsLastStatement(SqlStatements::WHERE);

        /** @var WhereCommand */
        $command = $this->getLastCommand();
        $command->addCondition(Operators::OR, $orWhere);
        return $this;
    }

    public function execute(): bool
    {
        $request = $this->getSqlRequest();
        var_dump($request);
        return $this->db->execute($request);
    }
}
