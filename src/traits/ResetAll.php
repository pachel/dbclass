<?php

namespace Pachel\db\Traits;

use Pachel\db\dbClass;

trait ResetAll
{

    /**
     * @var dbClass
     */
    protected dbClass $db;

    protected function resetAllParameter(): void
    {
        $this->db->parameters["searchtext"] = null;
        $this->db->parameters["limit"] = null;
        $this->db->parameters["where"] = null;
    }
}
