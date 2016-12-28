<?php

namespace Interpro\Extractor\Contracts\Db;

use Interpro\Core\Contracts\Mediatable;
use Interpro\Core\Contracts\Ref\ARef;
use Interpro\Extractor\Contracts\Selection\SelectionUnit;

interface CMapper extends Mediatable
{
    /**
     * @param \Interpro\Core\Contracts\Ref\ARef $ref
     * @param bool $asUnitMember
     *
     * @return \Interpro\Extractor\Contracts\Collections\MapCCollection
     */
    public function getByRef(ARef $ref, $asUnitMember = false);

    /**
     * @param \Interpro\Extractor\Contracts\Selection\SelectionUnit $selectionUnit
     *
     * @return \Interpro\Extractor\Contracts\Collections\MapCCollection
     */
    public function select(SelectionUnit $selectionUnit);

    /**
     * @return void
     */
    public function reset();
}
