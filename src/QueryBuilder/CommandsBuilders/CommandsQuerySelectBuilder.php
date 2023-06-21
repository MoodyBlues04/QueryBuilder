<?php

declare(strict_types=1);

namespace src\QueryBuilder\CommandsBuilders;

use src\db\db;
use src\db\DbConfigDto;
use src\QueryBuilder\SqlCommands\FromCommand;
use src\QueryBuilder\SqlCommands\GroupByCommand;
use src\QueryBuilder\SqlCommands\HavingCommand;
use src\QueryBuilder\SqlCommands\LimitCommand;
use src\QueryBuilder\SqlCommands\OrderByCommand;
use src\QueryBuilder\SqlCommands\SelectCommand;
use src\QueryBuilder\SqlCommands\SqlStatements;
use src\QueryBuilder\SqlCommands\WhereCommand;

class CommandsQuerySelectBuilder extends BaseCommandsQueryBuilder
{
    private db $db;

    public function __construct(DbConfigDto $dbConfigDto)
    {
        $this->db = db::getInstance($dbConfigDto);
    }

    /**
     * @throws \LogicException
     */
    public function select(string|array $select): self
    {
        $this->checkIsFirstStatement();
        $this->addCommand(new SelectCommand($select));
        return $this;
    }

    /**
     * @throws \LogicException
     */
    public function from(string $from): self
    {
        $this->checkIsLastStatement(SqlStatements::SELECT);
        $this->addCommand(new FromCommand($from));
        return $this;
    }

    /**
     * Adds where statement
     * 
     * Supported param types:
     * ['key' => 'value']
     * ['>', 'key', 'value']
     * ['between', 'key', 'value_from', 'value_to']
     * ['like', 'value', 'regexp']
     */
    public function where(array $where): self
    {
        $this->checkIsLastStatement(SqlStatements::FROM);

        $this->addCommand(new WhereCommand($where));
        return $this;
    }

    public function groupBy(array|string $groupBy): self
    {
        $this->addCommand(new GroupByCommand($groupBy));
        return $this;
    }

    /**
     * Adds having statement
     * 
     * Supports types:
     * ['func', 'key', '>', 'value']
     * ['func', 'key', 'between', 'value_from', 'value_to]
     * 
     * func can be: sum, max, min, count
     */
    public function having(array|string $having): self
    {
        $this->checkIsLastStatement(SqlStatements::GROUP_BY);

        $this->addCommand(new HavingCommand($having));
        return $this;
    }

    /**
     * Adds order by statement
     * 
     * Supported types:
     * [key => SORT_DESC|SORT_ASC]
     * 'key' default sort asc
     */
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
        return $this->db->query($request);
    }

    public function one(): ?array
    {
        $rows = $this->all();
        return $rows[0] ?? null;
    }
}
