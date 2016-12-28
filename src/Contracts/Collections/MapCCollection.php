<?php

namespace Interpro\Extractor\Contracts\Collections;

use Interpro\Core\Contracts\Ref\ARef;
use Interpro\Extractor\Contracts\Items\COwnItem;

interface MapCCollection
{
    /**
     * @param \Interpro\Core\Contracts\Ref\ARef $ref
     *
     * @return \Interpro\Extractor\Contracts\Items\COwnItem
     */
    public function getItem(ARef $ref, $field_name);

    /**
     * @param \Interpro\Core\Contracts\Ref\ARef $ref
     * @param string $field_name
     * @param \Interpro\Extractor\Contracts\Items\COwnItem $item
     *
     * @return void
     */
    public function addItem(ARef $ref, $field_name, COwnItem $item);
}
