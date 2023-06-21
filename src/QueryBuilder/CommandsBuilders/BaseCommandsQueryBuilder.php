<?php

declare(strict_types=1);

namespace src\QueryBuilder\CommandsBuilders;

use src\QueryBuilder\SqlCommands\SqlCommand;

abstract class BaseCommandsQueryBuilder
{
    /**
     * @var SqlCommand[]
     */
    protected array $commands = [];

    public function addCommand(SqlCommand $command)
    {
        $this->commands[] = $command;
    }

    public function getSqlRequest(): string
    {
        $request = '';
        foreach ($this->commands as $command) {
            $request .= $command->getSqlRequest() . "\n";
        }

        return $request;
    }
}
