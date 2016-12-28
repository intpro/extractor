<?php

namespace Interpro\Extractor\Contracts\Items;

interface GroupItem extends AItem
{
    /**
     * @return \Interpro\Core\Taxonomy\Types\GroupType
     */
    public function getType();
}
