<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

abstract class SqlCommand
{
    abstract public function getStatementName(): string;
    abstract protected function getSqlQuery(): string;

    final public function getSqlRequest(): string
    {
        return "{$this->getStatementName()} {$this->getSqlQuery()}";
    }
}
