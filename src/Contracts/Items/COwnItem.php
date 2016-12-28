<?php

namespace Interpro\Extractor\Contracts\Items;

interface COwnItem extends OwnItem
{
    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Types\CType
     */
    public function getType();

    /**
     * @return bool
     */
    public function cap();
}
