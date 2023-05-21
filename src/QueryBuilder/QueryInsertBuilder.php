<?php

declare(strict_types=1);

namespace src\QueryBuilder;

use src\db\db;
use src\db\DbConfigDto;

class QueryInsertBuilder
{
    private db $db;

    private QueryInsertParams $params;

    public function __construct(DbConfigDto $dbConfigDto)
    {
        $this->db = db::getInstance($dbConfigDto);
        $this->params = new QueryInsertParams();
    }

    public function into(string $into): self
    {
        $this->params->setInto($into);
        return $this;
    }

    public function columns(array|string $columns): self
    {
        $this->params->setColumns($columns);
        return $this;
    }

    public function values(array|string $values): self
    {
        $this->params->setValues($values);
        return $this;
    }

    public function execute(): bool
    {
        $request = $this->params->getRequest();
        var_dump($request);
        return $this->db->execute($request);
    }
}
