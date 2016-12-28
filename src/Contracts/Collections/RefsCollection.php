<?php

namespace Interpro\Extractor\Contracts\Collections;

use Interpro\Core\Contracts\Taxonomy\Collections\NamedCollection;
use Interpro\Extractor\Contracts\Fields\RefField;

interface RefsCollection extends NamedCollection
{
    /**
     * @param string $field_name
     *
     * @return \Interpro\Extractor\Contracts\Fields\RefField
     */
    public function getRefByName($field_name);

    /**
     * @param \Interpro\Extractor\Contracts\Fields\RefField
     *
     * @return void
     */
    public function addRef(RefField $refField);

}
