<?php

namespace Pachel\db\Traits;

use Pachel\db\dbClass;

trait Search
{
    /**
     * @var string $query
     */
    protected string $query;
    /**
     * @var dbClass $db
     */
    protected dbClass $db;

    /**
     * --------------------------------------------------------------------------
     *
     * --------------------------------------------------------------------------
     * @param string $searchtext
     * @return array
     */
    public function search($text){
        $this->db->parameters["searchtext"] = $text;
        $d = new From($this->db);
        return $d->array();
    }
}
