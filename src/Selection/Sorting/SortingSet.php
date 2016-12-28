<?php

namespace Interpro\Extractor\Selection\Sorting;

use Illuminate\Support\Facades\Log;
use Interpro\Core\Contracts\Taxonomy\Types\AggrType;
use Interpro\Extractor\Contracts\Selection\SortingSet as SortingSetInterface;
use Interpro\Extractor\Contracts\Selection\SortingUnit as SortingUnitInterface;
use Interpro\Extractor\Db\QueryBuilder as Builder;

class SortingSet implements SortingSetInterface
{
    private $fields_paths;
    private $units;
    private $Atype;

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\AggrType $Atype
     *
     * @return void
     */
    public function __construct(AggrType $Atype)
    {
        $this->Atype   = $Atype;
        $this->fields_paths = [];
        $this->units        = [];
    }

    /**
     * @param Builder $query
     *
     * @return void
     */
    public function applyAll(Builder $query)
    {
        foreach($this->units as $unit)
        {
            $unit->apply($query);
        }
    }

    /**
     * @return array
     */
    public function getJoinFieldsPaths()
    {
        return $this->fields_paths;
    }

    /**
     * @param \Interpro\Extractor\Contracts\Selection\SortingUnit $sortUnit
     *
     * @return void
     */
    public function addUnit(SortingUnitInterface $sortUnit)
    {
        $this->units[] = $sortUnit;
        $this->fields_paths[] = $sortUnit->getFieldName();
    }
}
