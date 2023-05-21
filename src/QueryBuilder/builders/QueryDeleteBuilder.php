<?php

declare(strict_types=1);

namespace src\QueryBuilder\builders;

use src\db\db;
use src\db\DbConfigDto;
use src\QueryBuilder\params\QueryDeleteParams;

class QueryDeleteBuilder
{
    private db $db;

    private QueryDeleteParams $params;

    public function __construct(DbConfigDto $dbConfigDto)
    {
        $this->db = db::getInstance($dbConfigDto);
        $this->params = new QueryDeleteParams();
    }

    public function from(string $from): self
    {
        $this->params->setFrom($from);
        return $this;
    }

    public function where(array $where): self
    {
        $this->params->setWhere($where);
        return $this;
    }

    public function execute(): bool
    {
        $request = $this->params->getRequest();
        return $this->db->execute($request);
    }
}
