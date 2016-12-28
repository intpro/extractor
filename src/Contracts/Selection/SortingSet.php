<?php

namespace Interpro\Extractor\Contracts\Selection;

use Interpro\Extractor\Db\QueryBuilder as Builder;

interface SortingSet
{
    /**
     * @param Builder $query
     *
     * @return void
     */
    public function applyAll(Builder $query);

    /**
     * @return array
     */
    public function getJoinFieldsPaths();

    /**
     * @param \Interpro\Extractor\Contracts\Selection\SortingUnit $sortUnit
     *
     * @return void
     */
    public function addUnit(SortingUnit $sortUnit);

}
