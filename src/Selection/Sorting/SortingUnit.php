<?php

namespace Interpro\Extractor\Selection\Sorting;

use Interpro\Extractor\Contracts\Selection\SortingUnit as SortingUnitInterface;
use Interpro\Extractor\Db\QueryBuilder as Builder;

class SortingUnit implements SortingUnitInterface
{
    private $field_name;
    private $order;
    private $field_alias;

    /**
     * @param $field_name
     * @param $order
     *
     * @return void
     */
    public function __construct($field_name, $order)
    {
        $this->field_name = $field_name;
        $this->field_alias = str_replace('.', '_', $this->field_name);
        $this->order      = $order;
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->field_name;
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function apply(Builder $query)
    {
        $query->orderBy($this->field_alias, $this->order);
    }
}
