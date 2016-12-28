<?php

namespace Interpro\Extractor\Contracts\Creation;

use Interpro\Core\Contracts\Taxonomy\Types\CType;

interface CItemBuilder
{
    /**
     * @param \Interpro\Extractor\Contracts\Creation\CItemFactory
     *
     * @return \Interpro\Extractor\Contracts\Db\AMapper
     */
    public function addFactory(CItemFactory $factory);

    /**
     * @param string $family
     *
     * @return \Interpro\Extractor\Contracts\Creation\CItemFactory
     */
    public function getFactory($family);

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\CType $type
     * @param mixed $value
     *
     * @return \Interpro\Extractor\Contracts\Items\COwnItem
     */
    public function create(CType $type, $value);

    /**
     * @param \Interpro\Core\Contracts\Taxonomy\Types\CType $type
     *
     * @return \Interpro\Extractor\Contracts\Items\COwnItem
     */
    public function createCap(CType $type);
}
