<?php

namespace Interpro\Extractor\Contracts\Selection;

use Interpro\Extractor\Db\QueryBuilder as Builder;

interface SpecificationUnit
{
    /**
     * @param Builder $query
     * @param bool $or
     *
     * @return mixed
     */
    public function apply(Builder $query, $or);

    /**
     * @return string
     */
    public function getFieldName();
}
