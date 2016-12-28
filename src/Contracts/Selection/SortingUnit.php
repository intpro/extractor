<?php

namespace Interpro\Extractor\Contracts\Selection;

use Interpro\Extractor\Db\QueryBuilder as Builder;

interface SortingUnit
{
    /**
     * @param Builder $query
     *
     * @return mixed
     */
    public function apply(Builder $query);

    /**
     * @return string
     */
    public function getFieldName();
}
