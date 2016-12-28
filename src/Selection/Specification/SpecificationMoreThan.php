<?php

namespace Interpro\Extractor\Selection\Specification;

use Interpro\Core\Contracts\Taxonomy\Types\AggrType;
use Interpro\Extractor\Db\QueryBuilder as Builder;
use Interpro\Extractor\Contracts\Selection\SpecificationUnit;

class SpecificationMoreThan implements SpecificationUnit
{
    private $value;
    private $Atype;
    private $field_name;
    private $field_alias;

    /**
     * @param string $Atype_name
     *
     * @return void
     */
    public function __construct(AggrType $Atype, $field_name, $value)
    {
        $this->Atype      = $Atype;
        $this->field_name = $field_name;
        $this->field_alias = str_replace('.', '_', $this->field_name);
        $this->value      = $value;
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
            $query->orWhere($field_alias, '>', $this->value);
        }
        else
        {
            $query->where($field_alias, '>', $this->value);
        }
    }
}
