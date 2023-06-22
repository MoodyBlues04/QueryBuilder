<?php

declare(strict_types=1);

namespace src\QueryBuilder\Builders;

use src\db\db;
use src\db\DbConfigDto;
use src\QueryBuilder\SqlCommands\Condition\Operators;
use src\QueryBuilder\SqlCommands\SetTableCommand;
use src\QueryBuilder\SqlCommands\GroupByCommand;
use src\QueryBuilder\SqlCommands\HavingCommand;
use src\QueryBuilder\SqlCommands\LimitCommand;
use src\QueryBuilder\SqlCommands\OrderByCommand;
use src\QueryBuilder\SqlCommands\SelectCommand;
use src\QueryBuilder\SqlCommands\SqlStatements;
use src\QueryBuilder\SqlCommands\WhereCommand;

class QuerySelectBuilder extends BaseCommandsQueryBuilder
{
    private db $db;

    public function __construct(DbConfigDto $dbConfigDto)
    {
        $this->db = db::getInstance($dbConfigDto);
    }

    public function select(string|array $select): self
    {
        $this->checkIsFirstStatement();
        $this->addCommand(new SelectCommand($select));
        return $this;
    }

    public function from(string $from): self
    {
        $this->checkIsLastStatement(SqlStatements::SELECT);
        $this->addCommand(new SetTableCommand(SqlStatements::FROM, $from));
        return $this;
    }

    public function where(array $where): self
    {
        $this->checkIsLastStatement(SqlStatements::FROM);

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

    public function groupBy(array|string $groupBy): self
    {
        $this->addCommand(new GroupByCommand($groupBy));
        return $this;
    }

    public function having(array|string $having): self
    {
        $this->checkIsLastStatement(SqlStatements::GROUP_BY);

        $this->addCommand(new HavingCommand($having));
        return $this;
    }

    public function andHaving(array $andHaving): self
    {
        $this->checkIsLastStatement(SqlStatements::HAVING);

        /** @var HavingCommand */
        $command = $this->getLastCommand();
        $command->addCondition(Operators::AND, $andHaving);
        return $this;
    }

    public function orHaving(array $orHaving): self
    {
        $this->checkIsLastStatement(SqlStatements::HAVING);

        /** @var HavingCommand */
        $command = $this->getLastCommand();
        $command->addCondition(Operators::OR, $orHaving);
        return $this;
    }

    public function orderBy(array|string $orderBy): self
    {
        $this->addCommand(new OrderByCommand($orderBy));
        return $this;
    }

    public function limit(int $limit): self
    {
        $this->addCommand(new LimitCommand($limit));
        return $this;
    }

    public function all(): ?array
    {
        $request = $this->getSqlRequest();
        var_dump($request);
        return $this->db->query($request);
    }

    public function one(): ?array
    {
        $rows = $this->all();
        return $rows[0] ?? null;
    }
}
