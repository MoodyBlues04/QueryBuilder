<?php

declare(strict_types=1);

namespace src\QueryBuilder\Builders;

use src\QueryBuilder\SqlCommands\SqlCommand;

abstract class BaseCommandsQueryBuilder
{
    /**
     * @var SqlCommand[]
     */
    protected array $commands = [];

    final public function addCommand(SqlCommand $command)
    {
        $this->commands[] = $command;
    }

    /**
     * @throws \InvalidArgumentException
     */
    final public function checkIsFirstStatement(): void
    {
        $lastStatement = $this->getLastCommandStatementName();
        if (!is_null($lastStatement)) {
            throw new \InvalidArgumentException("You should call this firstly, not after {$lastStatement}");
        }
    }

    /**
     * @throws \InvalidArgumentException
     */
    final public function checkIsLastStatement(string $expected): void
    {
        $lastStatement = $this->getLastCommandStatementName();
        if ($lastStatement !== $expected) {
            throw new \InvalidArgumentException("You should call this after {$expected}, not {$lastStatement}");
        }
    }

    final public function getLastCommandStatementName(): ?string
    {
        $command = $this->getLastCommand();
        return !is_null($command) ? $command->getStatementName() : null;
    }

    final public function getLastCommand(): ?SqlCommand
    {
        return !empty($this->commands) ? end($this->commands) : null;
    }

    final public function getSqlRequest(): string
    {
        $request = '';
        foreach ($this->commands as $command) {
            $request .= $command->getSqlRequest() . "\n";
        }
        return $request;
    }
}
