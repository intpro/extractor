<?php

namespace Interpro\Extractor\Contracts\Collections;

use Interpro\Core\Contracts\Taxonomy\Collections\NamedCollection;
use Interpro\Extractor\Contracts\Fields\OwnField;

interface OwnsCollection extends NamedCollection
{
    /**
     * @param string $field_name
     *
     * @return \Interpro\Extractor\Contracts\Fields\OwnField
     */
    public function getOwnByName($field_name);

    /**
     * @param \Interpro\Extractor\Contracts\Fields\OwnField
     *
     * @return void
     */
    public function addOwn(OwnField $ownField);

}
