<?php

declare(strict_types=1);

namespace src\QueryBuilder\SqlCommands;

class SqlStatements
{
    const SELECT   = 'SELECT';
    const UPDATE   = 'UPDATE';
    const INSERT   = 'INSERT';
    const DELETE   = 'DELETE';
    const FROM     = 'FROM';
    const INTO     = 'INTO';
    const COLUMNS  = '';
    const VALUES   = 'VALUES';
    const SET      = 'SET';
    const WHERE    = 'WHERE';
    const GROUP_BY = 'GROUP BY';
    const HAVING   = 'HAVING';
    const ORDER_BY = 'ORDER BY';
    const LIMIT    = 'LIMIT';
}
