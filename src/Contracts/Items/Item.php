<?php

namespace Interpro\Extractor\Contracts\Items;

interface Item
{
    /**
     * @return \Interpro\Core\Contracts\Taxonomy\Types\Type
     */
    public function getType();

    /**
     * @return bool
     */
    public function cap();
}
