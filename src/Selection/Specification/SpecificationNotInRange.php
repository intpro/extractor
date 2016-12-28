<?php

namespace Interpro\Extractor\Selection\Specification;

use Interpro\Core\Contracts\Taxonomy\Types\AggrType;
use Interpro\Extractor\Db\QueryBuilder as Builder;
use Interpro\Extractor\Contracts\Selection\SpecificationUnit;

class SpecificationNotInRange implements SpecificationUnit
{
    private $value_min;
    private $value_max;
    private $Atype;
    private $field_name;
    private $field_alias;

    /**
     * @param string $Atype_name
     * @param mixed $value_min
     * @param mixed $value_max
     *
     * @return void
     */
    public function __construct(AggrType $Atype, $field_name, $value_min, $value_max)
    {
        $this->Atype      = $Atype;
        $this->field_name = $field_name;
        $this->field_alias = str_replace('.', '_', $this->field_name);
        $this->value_min  = $value_min;
        $this->value_max  = $value_max;
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
     * @param bool $or
     *
     * @return void
     */
    public function apply(Builder $query, $or = false)
    {
        $field_alias = $this->field_alias;

        if($or)
        {
            $query->orWhereNotBetween($field_alias, [$this->value_min, $this->value_max]);
        }
        else
        {
            $query->whereNotBetween($field_alias, [$this->value_min, $this->value_max]);
        }
    }
}
