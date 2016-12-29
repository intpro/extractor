<?php

namespace Interpro\Extractor\Load;

use Interpro\Core\Contracts\Ref\ARef;
use Interpro\Extractor\Contracts\Db\AMapper;
use Interpro\Extractor\Contracts\Selection\SelectionUnit;

class CapAMapper implements AMapper
{
    public function getFamily()
    {

    }

    /**
     * @param \Interpro\Core\Contracts\Ref\ARef $ref
     * @param bool $asUnitMember
     *
     * @return \Interpro\Extractor\Contracts\Items\AItem
     */
    public function getByRef(ARef $ref, $asUnitMember = false)
    {

    }

    /**
     * @param \Interpro\Extractor\Contracts\Selection\SelectionUnit $selectionUnit
     *
     * @return \Interpro\Extractor\Contracts\Collections\MapGroupCollection
     */
    public function select(SelectionUnit $selectionUnit)
    {

    }

    /**
     * @param \Interpro\Extractor\Contracts\Selection\SelectionUnit $selectionUnit
     *
     * @return int
     */
    public function count(SelectionUnit $selectionUnit)
    {

    }

    /**
     * @return void
     */
    public function reset()
    {

    }

}
