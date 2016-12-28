<?php

namespace Interpro\Extractor\Contracts\Selection;

use Interpro\Extractor\Db\QueryBuilder as Builder;

interface ParamSet
{
    /**
     * @param int $value
     *
     * @return void
     */
    public function skip($value);

    /**
     * @param int $value
     *
     * @return void
     */
    public function take($value);

    /**
     * @param Builder $query
     *
     * @return void
     */
    public function apply(Builder $query);

}
