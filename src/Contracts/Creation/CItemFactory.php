<?php

namespace Interpro\Extractor\Contracts\Creation;

use Interpro\Core\Contracts\Mediatable;
use Interpro\Core\Contracts\Taxonomy\Types\CType;

interface CItemFactory extends Mediatable
{
    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\CType $type
     * @param mixed $value
     *
     * @return \Interpro\Extractor\Contracts\Items\COwnItem COwnItem
     */
    public function create(CType $type, $value);

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\CType $type
     *
     * @return \Interpro\Extractor\Contracts\Items\COwnItem COwnItem
     */
    public function createCap(CType $type);


}
