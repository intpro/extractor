<?php

namespace Interpro\Extractor\Contracts\Items;

interface AggrOwnItem extends OwnItem, Aggr
{
    /**
     * @return \Interpro\Core\Taxonomy\Types\BModeType
     */
    public function getType();

    /**
     * @return bool
     */
    public function cap();
}
